const contentTabs=document.querySelectorAll('.tab-content');
const applsTimeUrl=`http://localhost/Kursak/lab5/api/ApplsTime.php`;
const applsTimeTableBody=document.querySelector('#applTimeTable tbody');
const applsTimeForm=document.getElementById('applTimeForm');
const sphrsofApplUrl=`http://localhost/Kursak/lab5/api/SphrsofAppl.php`;
const sphrsofApplTableBody=document.querySelector('#sphrofApplTable tbody');
const sphrsofApplForm=document.getElementById('sphrofApplForm');
const propertiesUrl=`http://localhost/Kursak/lab5/api/Properties.php`;
const propertiesTableBody=document.querySelector('#propertyTable tbody');
const propertiesForm=document.getElementById('propertyForm');
const sunScreensUrl=`http://localhost/Kursak/lab5/api/SunScreens.php`;
const sunScreensTableBody=document.querySelector('#sunScreenTable tbody');
const sunScreensForm=document.getElementById('sunScreenForm');
const loginForm=document.getElementById('loginForm');
const profileUrl=`http://localhost/Kursak/lab5/api/Profile.php`;
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
            displayApplsTime();
            displaySphrsofAppl();
            displayProperties();
            displaySunScreens();
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
showContentTab('#applTimeContent');
function displayApplsTime(){
    fetch(applsTimeUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let applsTime=data.applsTime;
        let content=``;
        for (let i=0;i<applsTime.length;i++){
            content+=`<tr>
                    <td>${applsTime[i].id}</td>
                    <td>${applsTime[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-applTime-btn" data-id="${applsTime[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-applTime-btn" data-id="${applsTime[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        applsTimeTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displaySphrsofAppl(){
    fetch(sphrsofApplUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let sphrsofAppl=data.sphrsofAppl;
        let content=``;
        for (let i=0;i<sphrsofAppl.length;i++){
            content+=`<tr>
                    <td>${sphrsofAppl[i].id}</td>
                    <td>${sphrsofAppl[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-sphrofAppl-btn" data-id="${sphrsofAppl[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-sphrofAppl-btn" data-id="${sphrsofAppl[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        sphrsofApplTableBody.innerHTML=content;
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
function displaySunScreens(){
    fetch(sunScreensUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let sunScreens=data.sunScreens;
        let content=``;
        for (let i=0;i<sunScreens.length;i++){
            let propertiesContent=``;
            for (const [key, value] of Object.entries(sunScreens[i].properties)) {
                propertiesContent+=`${key}: ${value} </br>`;
            }
            content+=`<tr>
                    <td>${sunScreens[i].id}</td>
                    <td>${sunScreens[i].vendor}</td>
                    <td>${sunScreens[i].name}</td>
                    <td>${sunScreens[i].applTime}</td>
                    <td>${sunScreens[i].sphrofAppl}</td>
                    <td>${sunScreens[i].price}</td>
                    <td>${propertiesContent}</td>
                    <td>
                        <a class="btn btn-warning edit-sunScreen-btn" data-id="${sunScreens[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-sunScreen-btn" data-id="${sunScreens[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        sunScreensTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
 applsTimeForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#applTimeForm input[name="name"]').value,
            id:document.querySelector('#applTimeForm input[name="id"]').value
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
        
        fetch(applsTimeUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            applsTimeForm.reset();
            document.querySelector('#applTimeForm input[name="id"]').value='';
            displayApplsTime();
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
                    displayApplsTime();
                    displaySphrsofAppl();
                    displayProperties();
                    displaySunScreens();
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
    sphrsofApplForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#sphrofApplForm input[name="name"]').value,
            id:document.querySelector('#sphrofApplForm input[name="id"]').value
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
        
        fetch(sphrsofApplUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            sphrsofApplForm.reset();
            document.querySelector('#sphrofApplForm input[name="id"]').value='';
            displaySphrsofAppl();
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
    sunScreensForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            vendor: document.querySelector('#sunScreenForm input[name="vendor"]').value,
            name: document.querySelector('#sunScreenForm input[name="name"]').value,
            price:document.querySelector('#sunScreenForm input[name="price"]').value,
            applTime: document.querySelector('#sunScreenForm input[name="applTime"]').value,
            sphrofAppl: document.querySelector('#sunScreenForm input[name="sphrofAppl"]').value,
            properties: document.querySelector('#sunScreenForm input[name="properties"]').value,
            id:document.querySelector('#sunScreenForm input[name="id"]').value
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
        
        fetch(sunScreensUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            sunScreensForm.reset();
            document.querySelector('#sunScreenForm input[name="id"]').value='';
            displaySunScreens();
        });

    });
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('delete-applTime-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(applsTimeUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayApplsTime();
        });    
  } else if (event.target.classList.contains('edit-applTime-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(applsTimeUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let applTime=data;
            document.querySelector('#applTimeForm input[name="name"]').value=applTime.name,
            document.querySelector('#applTimeForm input[name="id"]').value=applTime.id
        });    
  }
    else if (event.target.classList.contains('delete-sphrofAppl-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(sphrsofApplUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displaySphrsofAppl();
        });    
  } else if (event.target.classList.contains('edit-sphrofAppl-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(sphrsofApplUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let sphrofAppl=data;
            document.querySelector('#sphrofApplForm input[name="name"]').value=sphrofAppl.name,
            document.querySelector('#sphrofApplForm input[name="id"]').value=sphrofAppl.id
        });    
  }
  else if (event.target.classList.contains('delete-property-btn')) {
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
  } else if (event.target.classList.contains('delete-sunScreen-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(sunScreensUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displaySunScreens();
        });    
  } else if (event.target.classList.contains('edit-sunScreen-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(sunScreensUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let sunScreen=data;
            document.querySelector('#sunScreenForm input[name="name"]').value=sunScreen.name,
            document.querySelector('#sunScreenForm input[name="vendor"]').value=sunScreen.vendor,
            document.querySelector('#sunScreenForm input[name="applTime"]').value=sunScreen.applTime,
            document.querySelector('#sunScreenForm input[name="sphrofAppl"]').value=sunScreen.sphrofAppl,
            document.querySelector('#sunScreenForm input[name="price"]').value=sunScreen.price,
            document.querySelector('#sunScreenForm input[name="properties"]').value=sunScreen.properties,
            document.querySelector('#sunScreenForm input[name="id"]').value=sunScreen.id
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