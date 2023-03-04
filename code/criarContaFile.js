window.onload = function(){
deletarMensagensFail();    
deletarMensagensSuccess();
}
function deletarMensagensFail(){
    let listElements = document.querySelectorAll('.failMessage');
    listElements.forEach(element => {
        setTimeout(() => {
            element.remove();
        }, 7000);
    })

}
function deletarMensagensSuccess(){
    let listElements = document.querySelectorAll('.successMessage');
    listElements.forEach(element => {
        setTimeout(() => {
            element.remove();
        }, 7000);
    })

}