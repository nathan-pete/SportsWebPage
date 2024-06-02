function inputSelect(zoneName) {
    // Making all input elements darker, and disabling them
    $(".zoneDiv").css("filter", "brightness(70%)").attr("disabled", true);
    // Making the clicked zone brighter and enabling them
    $(zoneName).css("filter", "brightness(110%)").attr("disabled", false);
    zoneSelected = true;
}

function inputMouseEnter(zoneName) {
    // Making all input elements darker
    $(".zoneDiv").css("filter", "brightness(70%)");
    // Making the hovered zone brighter
    $(zoneName).css("filter", "brightness(110%)");
}

function inputMouseLeave(zoneName) {
    // Reverting all elements to initial state
    $(".zoneDiv").css("filter", "brightness(100%)");
}

function noSeatSelected() {
    $(".seatSubmit input[type=submit]").attr("disabled", true);
}

function seatSelected() {
    $(".seatSubmit input[type=submit]").attr("disabled", false);
}

function addAmount(price) {
    amount += price;
    $(".seatAmount").html("<h2>Total: $" + amount + "</h2>");
    seatSelected();
}

function removeAmount(price) {
    amount -= price;
    if (amount === 0) {
        $(".seatAmount").html("<h2>Total: <span style='color: red'>$" + amount + "</span></h2>");
        noSeatSelected();
    } else {
        $(".seatAmount").html("<h2>Total: $" + amount + "</h2>");
        seatSelected();
    }
}

let zoneSelected = false;
let zoneName = "";
let amount = 0;

$(function () {
    // Triggers on hovering
    $(".zoneTicket").on("mouseenter", function () {
        if (zoneSelected !== true) {
            // Getting the second class from the div
            let zone = $(this).attr("class").split(" ")[1];
            // Getting the letter from the end of the word (A,B,S or VIP)
            let zoneName = ".input" + zone.substr(2);
            inputMouseEnter(zoneName);
        }
    }).on("mouseleave", function () {
            if (zoneSelected !== true) {
                // Getting the second class from the div
                let zone = $(this).attr("class").split(" ")[1];
                // Getting the letter from the end of the word (A,B,S or VIP)
                let zoneName = ".input" + zone.substr(2);
                inputMouseLeave(zoneName);
            }
        }
    )

// Triggers on click
    $(".zoneTicket").on("click", function () {
            // Getting the second class from the div
            let zone = $(this).attr("class").split(" ")[1];
            // Getting the letter from the end of the word (A,B,S or VIP)
            let zoneName = ".input" + zone.substr(2);
            inputSelect(zoneName);
        }
    )
    $(".zoneDiv").on("click", function () {
        let ifDisabled = $(this).attr("disabled");
        zoneName = $(this).attr("zone");
        // If the div has the attribute disabled the function is NOT executed
        if (ifDisabled !== "disabled") {
            $.ajax({
                    type: "POST",
                    url: "../Ticket/SeatBookFiles/seatDisplay.php",
                    data: {
                        "zoneID": zoneName
                    },
                    success: function (data) {
                        $(".seatDisplay").html(data);
                    },
                    // AJAX loaded elements are not seen by javascript by default. This function helps to fix this problem by executing the code inside only after AJAX has successfully completed
                    complete: function () {
                        // Disabling the submit button
                        noSeatSelected();
                        $(".seats ul li input[type=checkbox]").on("change", function () {
                                let seatChecked = $(this).is(":checked");
                                $.ajax({
                                    type: "POST",
                                    url: "../Ticket/SeatBookFiles/priceCheck.php",
                                    data: {
                                        "zoneID": zoneName
                                    },
                                    success: function (data) {
                                        data = parseInt(data);
                                        if (seatChecked) {
                                            addAmount(data);
                                        } else {
                                            removeAmount(data);
                                        }
                                    }
                                })
                            }
                        )
                    }
                }
            )
        }
    })
})
