function expandActions(){
    if(window.getComputedStyle(document.getElementById('row-1'),null).getPropertyValue("width") == '0px'){
        document.getElementById('row-1').style.width = '10%';
    }    
    else{
        document.getElementById('row-1').style.width = '0%';
    }
}


//view_request

//init elements
var isEdit = false;
var projectID = document.getElementById('projectID');
var taskID = document.getElementById('taskID');
var projectOwner = document.getElementById('projectOwner');
var sender = document.getElementById('sender');
var receiver = document.getElementById('receiver');
var documentType = document.getElementById('documentType');

//init content holders
var projectIDContent =  projectID.innerText;
var taskIDContent = taskID.innerText;
var projectOwnerContent = projectOwner.innerText;
var senderContent = sender.innerText;
var receiverContent = receiver.innerText;
var documentTypeContent = documentType.innerText;

//init button listeners
var editButton = document.getElementById('edit')
var saveButton = document.getElementById('save')

//function triggers
saveButton.onclick = saveChanges;
editButton.onclick = toggleEdit;

//main edit
function toggleEdit(){
    if(isEdit){
        toDisplay();
        saveButton.style.display = 'none';
        isEdit = false;
    }

    else{
        toEdit();
        saveButton.style.display = 'inline';
        isEdit = true;
    }
}

//save to server and update holedrs
function saveChanges(){
    projectIDContent = document.getElementById('projectIDInput').value
    taskIDContent = document.getElementById('taskIDInput').value
    projectOwnerContent =  document.getElementById('projectOwnerInput').value
    senderContent =  document.getElementById('senderInput').value
    receiverContent = document.getElementById('receiverInput').value
    documentTypeContent =  document.getElementById('documentTypeInput').value

    toDisplay();
    saveButton.style.display = 'none';
    isEdit = false;
    console.log('doign ajax magic here')
}

//toggle textbox
function toEdit(){
    projectID.innerHTML = '<input id=\'projectIDInput\' value='+projectIDContent+ '></input>';
    taskID.innerHTML = '<input id=\'taskIDInput\' value='+taskIDContent+ '></input>';
    projectOwner.innerHTML = '<input id=\'projectOwnerInput\' value='+projectOwnerContent+ '></input>';
    sender.innerHTML = '<input id=\'senderInput\' value='+senderContent+ '></input>';
    receiver.innerHTML = '<input id=\'receiverInput\' value='+receiverContent+ '></input>';
    documentType.innerHTML = '<input id=\'documentTypeInput\' value='+documentTypeContent+ '></input>';
}

//toggle display
function toDisplay(){
    projectID.innerHTML = projectIDContent;
    taskID.innerHTML = taskIDContent;
    projectOwner.innerHTML = projectOwnerContent;
    sender.innerHTML =senderContent;
    receiver.innerHTML = receiverContent;
    documentType.innerHTML =documentTypeContent;
}