// Functions for canned reports

// Function to filter canned Active Directory report list

jQuery(function() {
    var opts = jQuery('#adreportname option').map(function() {
        return [[jQuery(this).text()]];
    });
    
    jQuery('#findItemAD').keyup(function() {
        
        var rxp = new RegExp(jQuery('#findItemAD').val(), 'i');
        var optlist = jQuery('#adreportname').empty();
        
        opts.each(function() {
            if(rxp.test(this[0])) {
                optlist.append(jQuery('<option/>').text(this[0]));
            }
        });
        
    });
    
});

// Function to filter canned File System report list

jQuery(function() {
    var opts = jQuery('#fsreportname option').map(function() {
        return [[jQuery(this).text()]];
    });
    
    jQuery('#findItemFS').keyup(function() {
        
        var rxp = new RegExp(jQuery('#findItemFS').val(), 'i');
        var optlist = jQuery('#fsreportname').empty();
        
        opts.each(function() {
            if(rxp.test(this[0])) {
                optlist.append(jQuery('<option/>').text(this[0]));
            }
        });
        
    });
    
});

// Function to filter canned Authentication report list

jQuery(function() {
    var opts = jQuery('#authreportname option').map(function() {
        return [[jQuery(this).text()]];
    });
    
    jQuery('#findItemAUTH').keyup(function() {
        
        var rxp = new RegExp(jQuery('#findItemAUTH').val(), 'i');
        var optlist = jQuery('#authreportname').empty();
        
        opts.each(function() {
            if(rxp.test(this[0])) {
                optlist.append(jQuery('<option/>').text(this[0]));
            }
        });
        
    });
    
});

// Function to filter canned GPO AD report list

jQuery(function() {
    var opts = jQuery('#gpoadreportname option').map(function() {
        return [[jQuery(this).text()]];
    });
    
    jQuery('#findItemGPOAD').keyup(function() {
        
        var rxp = new RegExp(jQuery('#findItemGPOAD').val(), 'i');
        var optlist = jQuery('#gpoadreportname').empty();
        
        opts.each(function() {
            if(rxp.test(this[0])) {
                optlist.append(jQuery('<option/>').text(this[0]));
            }
        });
        
    });
    
});

// Function to filter canned GPO FS report list

jQuery(function() {
    var opts = jQuery('#gpofsreportname option').map(function() {
        return [[jQuery(this).text()]];
    });
    
    jQuery('#findItemGPOFS').keyup(function() {
        
        var rxp = new RegExp(jQuery('#findItemGPOFS').val(), 'i');
        var optlist = jQuery('#gpofsreportname').empty();
        
        opts.each(function() {
            if(rxp.test(this[0])) {
                optlist.append(jQuery('<option/>').text(this[0]));
            }
        });
        
    });
    
});

// AD Reports - Sets Appropriate Columns

function selectAllOptionsad()
{
  var selObj = document.getElementById('selectedcolumnsad');
  for (var i=0; i<selObj.options.length; i++) {
    selObj.options[i].selected = true;
  }
}

// FS Reports - Sets Appropriate Columns

function selectAllOptionsfs()
{
  var selObj = document.getElementById('selectedcolumnsfs');
  for (var i=0; i<selObj.options.length; i++) {
    selObj.options[i].selected = true;
  }
}

// Auth Reports - Sets Appropriate Columns

function selectAllOptionsauth()
{
  var selObj = document.getElementById('selectedcolumnsauth');
  for (var i=0; i<selObj.options.length; i++) {
    selObj.options[i].selected = true;
  }
}

// GPO AD Reports - Sets Appropriate Columns

function selectAllOptionsgpoad()
{
  var selObj = document.getElementById('selectedcolumnsgpoad');
  for (var i=0; i<selObj.options.length; i++) {
    selObj.options[i].selected = true;
  }
}

// GPO FS Reports - Sets Appropriate Columns

function selectAllOptionsgpofs()
{
  var selObj = document.getElementById('selectedcolumnsgpofs');
  for (var i=0; i<selObj.options.length; i++) {
    selObj.options[i].selected = true;
  }
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}