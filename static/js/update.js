var evtListenerUpdate = evt => {
    let title = document.querySelector('input[name=title][type=text]'),
        email = document.querySelector('input[name=email][type=email]'),
        content = document.querySelector('textarea[name=content]'),
        btn = document.querySelector('#btn-update')
    if (title.value != '' && email.value != '' && content.value != '') {
        btn.className = 'button is-primary is-loading'
        setTimeout(() => {
            $.ajax({
                url: '/update',
                method: "POST",
                data: $('#update-form').serialize()
            }).then(function (res) {
                window.location.replace('/')
            }).catch(function (rej) {
                console.log("Connection Problem")
            })
            btn.className = 'button is-primary'
        }, 1500)
    } else if (content.value == '') {
        content.className = 'textarea is-danger'
    }
    evt.preventDefault()
}

var evtListenerTitle = evt => {
    let title = document.querySelector('input[name=title][type=text]'),
        titleHelp = document.querySelector('#title-help'),
        reTitle = /(.){4,}/
    if (!reTitle.test(title.value)) {
        title.className = 'input is-danger'
        titleHelp.className = 'help is-danger'
        titleHelp.innerHTML = 'The title is not valid'
    } else if (reTitle.test(title.value)) {
        title.className = 'input is-success'
        titleHelp.className = 'help is-success'
        titleHelp.innerHTML = 'The title is valid'
    }
    evt.preventDefault()
}

var evtListenerEmail = evt => {
    let email = document.querySelector('input[name=email][type=email]'),
        help = document.querySelector('#email-help')
    if (!emailValidation(email.value)) {
        email.className = 'input is-danger'
        help.className = 'help is-danger'
        help.innerHTML = 'Email is not currect'
    } else if (emailValidation(email.value)) {
        email.className = 'input is-success'
        help.className = 'help is-success'
        help.innerHTML = 'Email is currect'
    }
    evt.preventDefault()
}

var emailValidation = email => {
    let reEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
	return reEmail.test(email)
}


document.addEventListener('DOMContentLoaded', () => {
    let email = document.querySelector('input[name=email]'),
        title = document.querySelector('input[name=title]'),
        buttonUpdate = document.querySelector('#btn-update')
    email.addEventListener('keyup', evtListenerEmail)
    title.addEventListener('keyup', evtListenerTitle)
    buttonUpdate.addEventListener('click', evtListenerUpdate)
})
