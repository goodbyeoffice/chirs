/**
 * File admin.js.
 *
 * Various javascript for the admin side of Wordpress, when the Chirs wordpress theme is installed
 *
 */
 
( function( $ ) {

    function validColor(color) {
        var d = $("<span/>").css("backgroundColor", "transparent").css("backgroundColor", color);
        return color !== "" && (d.css("backgroundColor") !== "transparent" || color === "transparent");
    }
    
    function setUpGradient() {
        var gradLeft, gradRight;
        
        if (validColor($("#gradient-left").val().trim())) {
            gradLeft = $("#gradient-left").val().trim();
        } else {
            gradLeft = "transparent";
        }
        if (validColor($("#gradient-right").val().trim())) {
            gradRight = $("#gradient-right").val().trim();
        } else {
            gradRight = "transparent";
        }
        
        $("#chirs_custom_metabox #gradient").css(
            "background-image",
            "linear-gradient(to right, " + gradLeft + " 0%, " + gradRight + " 100%)"
        );
    }

    $(document).ready(function() {
    	
    	setUpGradient();
    	$("#chirs_custom_metabox #gradient-left, #chirs_custom_metabox #gradient-right").on("input", function() {
    	    setUpGradient();
    	});
    	
    }); // close document ready

} )( jQuery );