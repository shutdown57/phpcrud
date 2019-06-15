var autoHeight = () => {
    $('div.container.content').css('min-height', 0)
    $('div.container.content').css(
        'min-height',
        $(document).height() - $('nav').height() - $('footer').height()
    )
}

$(window).resize(() => autoHeight())

$(document).ready(() => {
    autoHeight()
})
