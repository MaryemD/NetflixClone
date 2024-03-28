//using JQuery to handle the muting and unmuting of the video by changing the html tag properties and displaying adequate icons

function volumeToggle(button) {
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);
    $(button).find("i").toggleClass("fa-volume-xmark");
    $(button).find("i").toggleClass("fa-volume-high");

}


//using JQuery to show the image after the video preview is over
function previewEnded() {
    $(".previewVideo").toggle();
    $(".previewImage").toggle();
}


