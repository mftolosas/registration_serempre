(function ($, Drupal, drupalSettings) {
    $( document ).ready(function() {   
        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Only alphabetical characters");      
        
        jQuery(function() {
            jQuery( "#registration-form" ).validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 4,
                        maxlength: 50,
                        lettersonly: true
                    }
                },
                messages: {
                    name: {
                        required: "This is a required field",
                        minlength: jQuery.format("Enter at least {0} characters"),
                        maxlength: jQuery.format("Enter maximum {0} characters"),
                    }
                }
            });
        });
    });
} (jQuery, Drupal, drupalSettings));