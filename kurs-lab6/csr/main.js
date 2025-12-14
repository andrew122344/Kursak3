const contentTabs=document.querySelectorAll('.tab-content');
const applsTimeUrl=`http://localhost/Kursak/kurs-lab6/api/ApplsTime.php`;
const applsTimeTableBody=document.querySelector('#applTimeTable tbody');
const applsTimeForm=document.getElementById('applTimeForm');
const sphrsofApplUrl=`http://localhost/Kursak/kurs-lab6/api/SphrsofAppl.php`;
const sphrsofApplTableBody=document.querySelector('#sphrofApplTable tbody');
const sphrsofApplForm=document.getElementById('sphrofApplForm');
const propertiesUrl=`http://localhost/Kursak/kurs-lab6/api/Properties.php`;
const propertiesTableBody=document.querySelector('#propertyTable tbody');
const propertiesForm=document.getElementById('propertyForm');
const sunScreensUrl=`http://localhost/Kursak/kurs-lab6/api/SunScreens.php`;
const sunScreensTableBody=document.querySelector('#sunScreenTable tbody');
const sunScreensForm=document.getElementById('sunScreenForm');
const loginForm=document.getElementById('loginForm');
const profileUrl=`http://localhost/Kursak/kurs-lab6/api/Profile.php`;
const applTimeDropdown=document.querySelector('#sunScreenForm select[name="applTimeid"]');
const sphrofApplDropdown=document.querySelector('#sunScreenForm select[name="sphrofApplid"]');
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
        let dropDownOptions=``;
        for (let i=0;i<applsTime.length;i++){
            dropDownOptions+=`<option value="${applsTime[i].id}">${applsTime[i].name}</option>`;
            content+=`<tr>
                    <td>${applsTime[i].id}</td>
                    <td>${applsTime[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-applTime-btn" data-id="${applsTime[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-applTime-btn" data-id="${applsTime[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        applTimeDropdown.innerHTML=dropDownOptions;
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
        let dropDownOptions=``;
        for (let i=0;i<sphrsofAppl.length;i++){
            dropDownOptions+=`<option value="${sphrsofAppl[i].id}">${sphrsofAppl[i].name}</option>`;
            content+=`<tr>
                    <td>${sphrsofAppl[i].id}</td>
                    <td>${sphrsofAppl[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-sphrofAppl-btn" data-id="${sphrsofAppl[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-sphrofAppl-btn" data-id="${sphrsofAppl[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        sphrofApplDropdown.innerHTML=dropDownOptions;
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
        let inputsContent=``;
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
                inputsContent+=`<p>
            <input type="text" class="form-control prop-input" required placeholder="${properties[i].name} ${properties[i].units}" name="prop_${properties[i].id}"/>
            </p>`
        }
        propertiesTableBody.innerHTML=content;
        document.getElementById('propertiesInputContainer').innerHTML=inputsContent;
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
            for (j=0;j<sunScreens[i].properties.length;j++){
                propertiesContent+=`
                ${sunScreens[i].properties[j].name}: ${sunScreens[i].properties[j].value} ${sunScreens[i].properties[j].units} </br>
                `
            }
            content+=`<tr>
                    <td>${sunScreens[i].id}</td>
                    <td>${sunScreens[i].vendor}</td>
                    <td>${sunScreens[i].name}</td>
                    <td>${sunScreens[i].applTimename}</td>
                    <td>${sunScreens[i].sphrofApplname}</td>
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
        let propInputs=document.querySelectorAll('.prop-input');
        let inputValuesArray=[];
        for(let i=0;i<propInputs.length;i++){
            inputValuesArray[propInputs[i].getAttribute('name')]=propInputs[i].value;
        } 
        const dataToSend = {
            vendor: document.querySelector('#sunScreenForm input[name="vendor"]').value,
            name: document.querySelector('#sunScreenForm input[name="name"]').value,
            price:document.querySelector('#sunScreenForm input[name="price"]').value,
            appltimeid: document.querySelector('#sunScreenForm select[name="applTimeid"]').value,
            sphrofapplid: document.querySelector('#sunScreenForm select[name="sphrofApplid"]').value,
            id:document.querySelector('#sunScreenForm input[name="id"]').value,
            ...inputValuesArray
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
            document.querySelector('#sunScreenForm select[name="applTimeid"]').value=sunScreen.applTimeid,
            document.querySelector('#sunScreenForm select[name="sphrofApplid"]').value=sunScreen.sphrofApplid,
            document.querySelector('#sunScreenForm input[name="price"]').value=sunScreen.price,
            document.querySelector('#sunScreenForm input[name="id"]').value=sunScreen.id;
            for (let i=0;i<sunScreen.properties.length;i++){
                document.querySelector('#sunScreenForm input[name="prop_'+sunScreen.properties[i].propertyid+'"]').value=sunScreen.properties[i].value;
            }
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