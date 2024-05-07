$(document).ready(function() {
    $('#left-panel a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('#main-area .content').hide();
        $(target).show();
    });
    $('#left-panel a:first').click();
});

