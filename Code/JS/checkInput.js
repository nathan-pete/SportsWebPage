// Function ensuring the REGISTER button is disabled only IF all inputs are OK
function buttDis() {
    let emailCheck = $("#emailCheck").text(); // .text is for retrieving the value/text the html ID has
    let passCheck = $("#passCheck").text();
    if (emailCheck.length === 0 && passCheck.length === 0) {
        $("#register").prop("disabled", false); // Using the .prop method we change attributes and their values
    }
}

// This function does display the ERROR message || messID = the id ot the <span> where the message will be displayed
// mess = The message which will be displayed
function message(messID, mess) {
    $(messID).text(mess);
}

// Function for displaying an error and changing html/css values if an input is NOT OK
function onMatchError(linkID, messID, mess) {
    $(linkID).css("border", "2px solid red");
    message(messID, mess);
    $("#register").prop("disabled", true);
}

// Function for reverting html/css values if the input is OK
function onMatchSuccess(linkID, messID, mess = "") {
    $(linkID).css("border", "2px solid black");
    message(messID, mess);
    buttDis();
}

// Password checking function, and comparing them
function passCheck(pass1, pass2) {
    if (
        pass1.match(/[A-Z]+/) !== null &&       // Checking for an upper case letter || " + " means it has to be present at least once
        pass1.match(/[a-z]+/) !== null &&       // Checking for a lower case letter
        pass1.match(/\d+/) !== null &&          // Checking for a digit
        pass1.match(/\W+/) !== null &&          // Checking for a symbol
        pass1.length > 8                        // Checking for password length
    ) {

        $(".passRequirements").css("transform", "scaleY(0)");
        $("#password2").prop("disabled", false);
        if (pass1 !== pass2) {
            onMatchError(".password", "#passCheck", "Passwords do not match!");
        } else {
            onMatchSuccess(".password", "#passCheck");
        }
    } else {
        $(".passRequirements").css("transform", "scaleY(1)");
        $("#password2").prop("disabled", true);
        onMatchError("#password1", "#passCheck", "Bad password!");
    }
}


// Equivalent to $(document).ready(), when the page is LOADED COMPLETELY, this code is executed
$(function () {

    // When the "eye" is pressed, the input changes to type=text and the icon changes to a "hidden eye"
    $(".passView").on("click", function () {
        let inputType = $("#password1").prop("type");
        if (inputType === "password") {
            $(this).prop("src", "../assets/view.png");
            $(".password").prop("type", "text");
        } else {
            $(this).prop("src", "../assets/hidden.png");
            $(".password").prop("type", "password");
        }
    });

    // After the email is entered (the user clicks besides the input), a post request is sent using AJAX to check if the
    // mail is in the database.

    // Also, this is used to check if the email is valid (using AJAX as well)
    $("#email").on("blur", function () {
        $.ajax({
            type: "POST",
            url: "./mailVerify.php",
            data: {"email": $("#email").val()},
            success: function (data) {
                if (data.length !== 0) {
                    onMatchError("#email", "#emailCheck", data);
                } else {
                    onMatchSuccess("#email", "#emailCheck");
                }
            }
        })
    });

    // The passwords are compared to see if they do match
    $("#password2").on("keyup", function () {
        let pass1 = $("#password1").val();
        let pass2 = $("#password2").val();
        // This function checks wherever or not the passwords meet the requirements
        passCheck(pass1, pass2);
    });

    // This does have the same purpose as the function above, only it triggers for another password input box

    $("#password1").on("keyup", function () {
        let pass1 = $("#password1").val();
        let pass2 = $("#password2").val();
        passCheck(pass1, pass2);
    });

})
