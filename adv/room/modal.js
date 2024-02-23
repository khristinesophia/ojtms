function openModal(req, passed, datepassed, verified, dateverified){
    const modal = document.querySelector('#req-modal');

    modal.classList.remove('modal');
    modal.classList.add('modal-active');

    document.querySelector('#req_name').value = req
    document.querySelector('#req_passed').value = passed;
    document.querySelector('#req_datepassed').value = datepassed;
    document.querySelector('#req_verified').value = verified;
    document.querySelector('#req_verified').innerText = verified;
    document.querySelector('#req_dateverified').value = dateverified;
}
function closeModal(){
    const modal = document.querySelector('#req-modal');

    modal.classList.remove('modal-active');
    modal.classList.add('modal');
}
// events

// open modal
document.querySelector('#req-table').addEventListener('click', (e)=>{
    if(e.target.classList.contains('edit')){
        row = e.target.parentElement.parentElement;
        const req = row.children[0].innerText;
        const passed = row.children[1].innerText;
        const datepassed = row.children[2].innerText;
        const verified = row.children[3].innerText;
        const dateverified = row.children[4].innerText;
        
        openModal(req, passed, datepassed, verified, dateverified);
    }
});
// submit form
document.querySelector('#editreq_btn').addEventListener('click', (e) => {
    e.preventDefault();

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "studsroom-editreq_adv.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            location.replace("studsroom_adv.php");
        }
    };

    var data = {
        req: document.querySelector('#req_name').value,
        passed: document.querySelector('#req_passed').value,
        datepassed: document.querySelector('#req_datepassed').value,
        verified: document.querySelector('#req_verifiedd').value,
        dateverified: document.querySelector('#req_dateverified').value,
        accesscode: document.querySelector('#access_code')
    };

    xhr.send(JSON.stringify(data));
})
// close modal
document.querySelector('#req-modal').addEventListener('click', (e)=>{
    if(e.target.classList.contains('close')){
        closeModal();
    }
});