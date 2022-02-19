$(function() {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on('click', function() {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on('click', function() {
        $(".app-search").toggle(200);
        $(".app-search input").focus();
    });

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();

    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //****************************
    var setsidebartype = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        if (width < 1170) {
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
    };
    $(window).ready(setsidebartype);
    $(window).on("resize", setsidebartype);

    $().ready(() => {
        $('#validateUser').click(function(event) {
            const element = event.target;
            const parent = element.closest('form');
            const usernameOrEmail = parent.querySelector('input[name="usernameOrEmail"]');
            const transferAmount = parent.querySelector('input[name="transferAmount"]');
            const submitButton = parent.querySelector('[type="submit"]');
            if (!usernameOrEmail.value.trim()) {
                usernameOrEmail.classList.add("is-invalid");
            } else {
                jsLaravel(parent)
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === "success") {
                            console.log(submitButton);
                            usernameOrEmail.classList.remove("is-invalid");
                            usernameOrEmail.classList.add("is-valid");
                            usernameOrEmail.classList.add("disabled");
                            $(usernameOrEmail).attr('readonly', true);

                            $(transferAmount).parent().show();
                            $(submitButton).parent().show();
                            $(element).hide();
                            res.message ? $(usernameOrEmail).siblings('.invalid-feedback')
                                .removeClass("invalid-feedback").addClass("valid-feedback").text(res.message) : '';
                            parent.action = "transactions/transfer-fund";
                        } else {
                            $(usernameOrEmail).removeClass("is-valid is-invalid disabled").addClass("is-invalid")
                            $(usernameOrEmail).attr("readonly", false);
                            res.message ? $(usernameOrEmail).siblings('.invalid-feedback').text(res.message) : '';
                        }
                    }).catch(err => {
                        $(usernameOrEmail).removeClass("is-valid is-invalid disabled").addClass("is-invalid")
                        $(usernameOrEmail).attr("readonly", false);
                        res.message ? $(usernameOrEmail).siblings('.invalid-feedback').text(res.message) : '';
                    })
            }
        })
    })

});