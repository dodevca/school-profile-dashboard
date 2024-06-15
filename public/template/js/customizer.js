const alert = document.getElementsByClassName('alert-temporary')
setTimeout(() => {
    for(let i = 0; i < alert.length;i ++) {
        alert[i].remove()
    }
}, "3000")

const updateList = () => {
    let input       = document.getElementById('images')
    let textEl      = document.getElementById('images-label')
    let output      = document.getElementById('file-list')
    let children    = ""
    let count       = 0

    for (var i = 0; i < input.files.length; ++i) {
        count++

        let text = count + ' gambar dipilih :'
        textEl.innerHTML = text

        children       += '<li>' + input.files.item(i).name + '</li>';
    }

    output.innerHTML = children;
}