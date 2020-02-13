function expandActions(){
    if(window.getComputedStyle(document.getElementById('row-1'),null).getPropertyValue("width") == '0px'){
        document.getElementById('row-1').style.width = '10%';
    }    
    else{
        document.getElementById('row-1').style.width = '0%';
    }
}