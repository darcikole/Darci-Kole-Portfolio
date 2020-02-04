// smooth scroll to all links
$(document).ready(function(){
    $( "a" ).click(function( event ) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top }, 1000);
    });
});

// contact form open/close //
function openForm() {
    document.getElementById("ModalScrollable").style.display = "block";
}

function closeForm() {
    document.getElementById("ModalScrollable").style.display = "none";
} 
