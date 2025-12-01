const contentTabs=document.querySelectorAll('.tab-content');
const categoriesUrl=`http://localhost/lab5/api/categories.php`;
const categoriesTableBody=document.querySelector('#categoryTable tbody');
const categoriesForm=document.getElementById('categoryForm');
const propertiesUrl=`http://localhost/lab5/api/properties.php`;
const propertiesTableBody=document.querySelector('#propertyTable tbody');
const propertiesForm=document.getElementById('propertyForm');
const backpacksUrl=`http://localhost/lab5/api/backpacks.php`;
const backpacksTableBody=document.querySelector('#backpackTable tbody');
const backpacksForm=document.getElementById('backpackForm');
const loginForm=document.getElementById('loginForm');
const profileUrl=`http://localhost/lab5/api/profile.php`;
function getLoginInfo(){
    fetch(profileUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if(!data.login){
            document.getElementById('loginContainer').style.display='block';
            document.getElementById('contentContainer').style.display='none';
        } else{
            document.getElementById('loginContainer').style.display='none';
            document.getElementById('contentContainer').style.display='block';
            displayCategories();
            displayProperties();
            displayBackpacks();
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function showContentTab(target){
    for(let i=0;i<contentTabs.length;i++){
        contentTabs[i].style.display='none';
    }
    document.querySelector(target).style.display='block';
}
showContentTab('#categoryContent');
function displayCategories(){
    fetch(categoriesUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let categories=data.categories;
        let content=``;
        for (let i=0;i<categories.length;i++){
            content+=`<tr>
                    <td>${categories[i].id}</td>
                    <td>${categories[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-category-btn" data-id="${categories[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-category-btn" data-id="${categories[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        categoriesTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displayProperties(){
    fetch(propertiesUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let properties=data.properties;
        let content=``;
        for (let i=0;i<properties.length;i++){
            content+=`<tr>
                    <td>${properties[i].id}</td>
                    <td>${properties[i].name}</td>
                    <td>${properties[i].units}</td>
                    <td>
                        <a class="btn btn-warning edit-property-btn" data-id="${properties[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-property-btn" data-id="${properties[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        propertiesTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displayBackpacks(){
    fetch(backpacksUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let backpacks=data.backpacks;
        let content=``;
        for (let i=0;i<backpacks.length;i++){
            let propertiesContent=``;
            for (const [key, value] of Object.entries(backpacks[i].properties)) {
                propertiesContent+=`${key}: ${value} </br>`;
            }
            content+=`<tr>
                    <td>${backpacks[i].id}</td>
                    <td>${backpacks[i].vendor}</td>
                    <td>${backpacks[i].model}</td>
                    <td>${backpacks[i].price}</td>
                    <td>${backpacks[i].category}</td>
                    <td>${propertiesContent}</td>
                    <td>
                        <a class="btn btn-warning edit-backpack-btn" data-id="${backpacks[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-backpack-btn" data-id="${backpacks[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        backpacksTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
 categoriesForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#categoryForm input[name="name"]').value,
            id:document.querySelector('#categoryForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(categoriesUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            categoriesForm.reset();
            document.querySelector('#categoryForm input[name="id"]').value='';
            displayCategories();
        });

    });
    loginForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            login: document.querySelector('#loginForm input[name="login"]').value,
            password:document.querySelector('#loginForm input[name="password"]').value
        };
        let options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        fetch(profileUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
            })
            .then(data => {
                if(!data.login){
                    document.getElementById('loginContainer').style.display='block';
                    document.getElementById('contentContainer').style.display='none';
                    document.getElementById('loginError').innerHTML='Неправильний логін або пароль';
                } else{
                    document.getElementById('loginContainer').style.display='none';
                    document.getElementById('contentContainer').style.display='block';
                    document.getElementById('loginError').innerHTML='';
                    displayCategories();
                    displayProperties();
                    displayBackpacks();
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
     propertiesForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            units: document.querySelector('#propertyForm input[name="units"]').value,
            name: document.querySelector('#propertyForm input[name="name"]').value,
            id:document.querySelector('#propertyForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(propertiesUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            propertiesForm.reset();
            document.querySelector('#propertyForm input[name="id"]').value='';
            displayProperties();
        });

    });
    backpacksForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            vendor: document.querySelector('#backpackForm input[name="vendor"]').value,
            model: document.querySelector('#backpackForm input[name="model"]').value,
            price:document.querySelector('#backpackForm input[name="price"]').value,
            category: document.querySelector('#backpackForm input[name="category"]').value,
            properties: document.querySelector('#backpackForm input[name="properties"]').value,
            id:document.querySelector('#backpackForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(backpacksUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            backpacksForm.reset();
            document.querySelector('#backpackForm input[name="id"]').value='';
            displayBackpacks();
        });

    });
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('delete-category-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(categoriesUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayCategories();
        });    
  } else if (event.target.classList.contains('edit-category-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(categoriesUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let category=data;
            document.querySelector('#categoryForm input[name="name"]').value=category.name,
            document.querySelector('#categoryForm input[name="id"]').value=category.id
        });    
  } else if (event.target.classList.contains('delete-property-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(propertiesUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayProperties();
        });    
  } else if (event.target.classList.contains('edit-property-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(propertiesUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let property=data;
            document.querySelector('#propertyForm input[name="units"]').value=property.units,
            document.querySelector('#propertyForm input[name="name"]').value=property.name,
            document.querySelector('#propertyForm input[name="id"]').value=property.id
        });    
  } else if (event.target.classList.contains('delete-backpack-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(backpacksUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayBackpacks();
        });    
  } else if (event.target.classList.contains('edit-backpack-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(backpacksUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let backpack=data;
            document.querySelector('#backpackForm input[name="model"]').value=backpack.model,
            document.querySelector('#backpackForm input[name="vendor"]').value=backpack.vendor,
            document.querySelector('#backpackForm input[name="category"]').value=backpack.category,
            document.querySelector('#backpackForm input[name="price"]').value=backpack.price,
            document.querySelector('#backpackForm input[name="properties"]').value=backpack.properties,
            document.querySelector('#backpackForm input[name="id"]').value=backpack.id
        });    
  }
   else if (event.target.classList.contains('nav-btn')) {
    event.preventDefault();
    if(event.target.id=='logoutBtn'){
        fetch(profileUrl+'?action=logout')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            getLoginInfo();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    } else{
        showContentTab(event.target.getAttribute('data-target'));
    }
  }
});    
getLoginInfo();