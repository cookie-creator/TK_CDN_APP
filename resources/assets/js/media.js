window.addEventListener('load', function() {

    let btnHeaderAdd = document.getElementById('btn-media-show-add')
    let btnBlockCancel = document.getElementById('btn-media-cancel');

    btnHeaderAdd.addEventListener('click', toggleBlockAdd);
    btnBlockCancel.addEventListener('click', toggleBlockAdd);

});

function toggleBlockAdd() {
    console.log('toggled');

    let blockAdd = document.getElementById('media-add-form');

    blockAdd.classList.toggle('hidden-block');
}
