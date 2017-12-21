(function($) {
    "use strict";
    $(function() {
        // globald begin
        var $window = $(window),
            $document = $(document);
        // globals end
        /* Script for the plugin settings page */
        /* Switch settings tabs */
        function switch_settings_tab(tab_id) {
            // Update tabs
            $('.nav-tab-wrapper .nav-tab').removeClass('nav-tab-active');
            $('.nav-tab-wrapper .nav-tab[href="' + tab_id + '"]').addClass('nav-tab-active');
            // Update tabs content
            $('#post-body-content .table').addClass('ui-tabs-hide');
            $('#post-body-content ' + tab_id).removeClass('ui-tabs-hide');
            // Update the form action to keep hash (anchor) after submitting the form
            $('#post-body-content #plugin-settings-form').attr('action', 'options.php' + tab_id);
        }
        if ($('.nav-tab-wrapper').length > 0) {
            // Switch tabs content on page load
            var current_tab = window.location.hash;
            if (current_tab == '') {
                current_tab = $('.nav-tab').first().attr('href');
                if (history.pushState) {
                    history.pushState(null, null, current_tab);
                } else {
                    window.location.hash = current_tab;
                }
            }
            switch_settings_tab(current_tab);
            // Switch tabs content on tab click
            $('.nav-tab-wrapper > .nav-tab').on('click', function(event) {
                event.preventDefault();
                var current_tab = $('.nav-tab').closest('.nav-tab-active').attr('href'); // Get current (active) tab id
                var new_tab = $(this).attr('href'); // Get new tab id
                // switch settings tabs if new tab is other than active tab
                if (current_tab !== new_tab) {
                    switch_settings_tab(new_tab);
                    // Update location hash (browser URL)
                    if (history.pushState) {
                        history.pushState(null, null, new_tab);
                    } else {
                        window.location.hash = new_tab;
                    }
                }
                return false;
            });
        }
        /* Settings Fields */
        /* Colorpicker */
        if ($('.field-colorpicker').length > 0) {
            $('.field-colorpicker').wpColorPicker();
            $('.wp-picker-holder').click(function(event) {
                event.preventDefault();
            })
        }
        /* END Colorpicker */
        /* Image upload field */
        if ($('.upload-image-button').length > 0) {
            $(document).on('click', '.upload-image-button', function() {
                var target_field = $(this).closest('.field-upload-image-wrapper').children('.field-upload-image');
                var target_field_preview = $(this).closest('.field-upload-image-wrapper').children('.field-upload-image-preview');
                window.send_to_editor = function(html) {
                    var image_url = $('img', html).attr('src');
                    $(target_field).val(image_url);
                    $('img', target_field_preview).attr('src', image_url);
                    window.send_to_editor = window.original_send_to_editor;
                    tb_remove();
                }
                tb_show('Image Upload', 'media-upload.php?type=image&amp;TB_iframe=true&amp;post_id=0', false);
                return false;
            });
        }
        /* END Image upload field */

        /*
        Addable option
         */
        var dialog, form,

            // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
            emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
            criteria = $( "#criteria" ),
            explanation = $( "#explanation" ),
            weight = $( "#weight" ),
            allFields = $( [] ).add( criteria ).add( explanation ).add( weight ),
            tips = $( ".validateTips" ),
            hiddenCriteriaField;

        dialog = $('#criteria-dialog');
        form = $('#criteria-dialog-form');
        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }

        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }

        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }

        function checkUnique(o) {
            try {
               var crits = JSON.parse(hiddenCriteriaField.val());
               var similar = crits.filter(function (el) {
                  return el.criteria === o.val();
               });
               console.log(similar.length);
               if (!similar.length) {
                   o.addClass( "ui-state-error" );
                   updateTips("Criteria field must be unique");
               }
               return !similar.length;
            } catch (e) {
                return false;
            }
        }

        function renderTd(obj) {
            return '<tr>' +
                '<td><input class="criteria-table-field" value="' + obj.criteria + '"></td>' +
                '<td><textarea class="criteria-table-field">' + obj.explanation + '</textarea></td>' +
                '<td><input class="criteria-table-field" type="number" value="' + obj.weight + '"></td>' +
                '<td><button class="delete-criteria" type="button" data-critid="' + obj.criteria + '">Delete</button></td></tr>';
        }

        /**
         * Addable options
         */
        function addCriteria() {
            console.log(form.val(), currentCriteriaField);
            var valid = true;
            allFields.removeClass( "ui-state-error" );

            valid = valid && checkLength( criteria, "criteria", 3, 50 ) && checkUnique(criteria);
            valid = valid && checkLength( explanation, "explanation", 6, 999 );
            valid = valid && checkLength( weight, "weight", 1, 3 );

            valid = valid && checkRegexp( criteria, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
            valid = valid && checkRegexp( explanation, /\w/, "eg. ui@jquery.com" );
            valid = valid && checkRegexp( weight, /^([0-9])+$/, "Password field only allow : a-z 0-9" );
            var criteriaObject = {
                criteria: criteria.val(),
                explanation: explanation.val(),
                weight: weight.val()
            };
            console.log(valid);
            console.log(criteria, weight.val());
            if ( valid ) {
                currentCriteriaField.find('tbody').append( renderTd(criteriaObject) );
                dialog.dialog( 'close' );
            }
            // hiddenCriteriaField

            var crits;
            console.log(hiddenCriteriaField, criteriaObject);
            try {
                crits = JSON.parse(hiddenCriteriaField.val());
                console.log(crits);
                if (Array.isArray(crits)) {
                    crits.push(criteriaObject);
                    hiddenCriteriaField.val(JSON.stringify(crits));
                } else {
                    crits = [criteriaObject];
                    hiddenCriteriaField.val(JSON.stringify(crits));
                }
            } catch (e) {
                crits = [criteriaObject];
                hiddenCriteriaField.val(JSON.stringify(crits));
                console.error(e.message);
            }

            return valid;
        }


        var currentCriteriaField;

        dialog = dialog.dialog({
            autoOpen: false,
            height: 500,
            width: 650,
            modal: true,
            buttons: {
                "Create an account": addCriteria,
                Cancel: function() {
                    dialog.dialog( "close" );
                }
            },
            close: function() {
                form[ 0 ].reset();
                // allFields.removeClass( "ui-state-error" );
            }
        });

        $document.on('click', '.add-criteria', function (event) {
           // event.preventDefault();
            dialog.dialog( "open" );
            var componentWrapper = $(this).closest('.addable-options');
            hiddenCriteriaField = componentWrapper.find('.review_for_criteria_options_hidden');
            currentCriteriaField = componentWrapper.find('.criteria-table');
        });
        $document.on('click', '.delete-criteria', function (event) {
            var $this = $(this);
            var componentWrapper = $this.closest('.addable-options');
            var itemId = $this.data('critid');
            var table = componentWrapper.find('tbody');
            hiddenCriteriaField = componentWrapper.find('.review_for_criteria_options_hidden');
            var items = JSON.parse(hiddenCriteriaField.val());
            console.log(items);
            table.html('');
            var newItems = items.filter(function (el) {
                if (el.criteria !== itemId) {
                    console.log(el.criteria, itemId);
                    table.append(renderTd(el));
                    return true;
                } else {
                    return false;
                }
            });
            console.log(newItems);
            hiddenCriteriaField.val(JSON.stringify(newItems));
        });
        $document.on('change', '.criteria-table-field', function () {
           var $this = $(this);
           var currentTr = $this.closest('tr');
           var delBtn = currentTr.find('.delete-criteria');
           var itemId = delBtn.data('critid');
           var componentWrapper = $this.closest('.addable-options');
           hiddenCriteriaField = componentWrapper.find('.review_for_criteria_options_hidden');
           var items = JSON.parse(hiddenCriteriaField.val());
           var currentItem = items.filter(function(el) { return el.criteria === itemId; })[0];
           console.log(currentItem, items, $this.val());
           var updatedItems = items.map(function (el) {
                if (el.criteria === itemId) {
                    el[$this.data('fname')] = $this.val();
                }
                return el;
           });
           console.log(items, updatedItems);
           hiddenCriteriaField.val(JSON.stringify(updatedItems));
           if($this.hasClass('criteria-table-field-criteria')) {
               delBtn.attr('data-critid', $this.val())
           }
        });
    });
}(jQuery));