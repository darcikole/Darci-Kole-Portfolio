// smooth scroll to all links
$('a[href*="#"]').on('click', function(e) {
    e.preventDefault()
  
    $('html, body').animate(
      {
        scrollTop: $($(this).attr('href')).offset().top,
      },
      500,
      'linear'
    )
  })

// contact form open/close //
function openForm() {
    document.getElementById("ModalScrollable").style.display = "block";
}

function closeForm() {
    document.getElementById("ModalScrollable").style.display = "none";
} 
