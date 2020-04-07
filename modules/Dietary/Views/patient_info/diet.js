
<script>
     $(document).ready(function() {
          // add minus icon for collapse element which is open by default
          $(".collapse.show").each(function() {
               $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
          });

          // toggle plus minus icon on show hide of collapse element
          $(".collapse").on('show.bs.collapse', function() {
               $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
          }).on('hide.bs.collapse', function() {
               $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
          });



          $("#food-allergies").tagsInput({
               'height': '2.5rem',
               'width': '100%',
               'defaultText': '',
               'onChange': function() {
                    var patientId = $("#patient-id").val();
                    var allergyName = ui.tagLabel;
                    $.post(SITE_URL, {
                         page: "PatientInfo",
                         action: "deleteItem",
                         patient: patientId,
                         name: allergyName,
                         type: "allergy"
                         }, function (e) {
                         console.log(e);
                         }, "json"
                    );
               },
          });


     });


     // var snackTime = null;
     // var thisFieldName = null;

     // startTag = function(category){

     //  $("#" + category).tagit({
     //    fieldName: category + "[]",
     //    //availableTags: fetchOptions(fetchOption),
        
     //    autocomplete: { delay: 0, minLength: 2},
     //    showAutocompleteOnFocus: false,
     //    caseSensitive: false,
     //    allowSpaces: true,
     //    beforeTagRemoved: function(event, ui){
     //      var patientId = $("patient-id").val();
     //      var Name = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: name,
     //        type: category
     //        }, function (e) {
     //          console.log(e);
     //      }, "json");
     //    }
     //  });
     // }

     // var tagOptions = ["adaptEquip", "allergies", "dislikes", "breakfast_beverages", "lunch_beverages", "dinner_beverages", "supplements", "breakfast_specialrequest", "lunch_specialrequest", "dinner_specialrequest"];

     // $.each(tagOptions, function(index, value) {
     //  startTag(value);
     // });

     // // for (category of tagOptions){
     // // 		startTag(category);
     // // }

     // //startTag("adaptEquip");



     // $("#dislikes").tagit({
     //  fieldName: "dislikes[]",
     //  availableTags: fetchOptions("Dislike"),
     //  showAutocompleteOnFocus: false,
     //  caseSensitive: false,
     //  allowSpaces: true,
     //  beforeTagRemoved: function(event, ui) {
     //      // if tag is removed, need to delete from the db
     //      var patientId = $("#patient-id").val();
     //      var dislikeName = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: dislikeName,
     //        type: "dislike"
     //        }, function (e) {
     //          console.log(e);
     //        }, "json"
     //      );
     //  }

     // });

     // $("#adaptEquip").tagit({
     // fieldName: "adaptEquip[]",
     //  availableTags: fetchOptions("AdaptEquip"),
     //    showAutocompleteOnFocus: false,
     //    caseSensitive: false,
     //    allowSpaces: true,

     //    beforeTagRemoved: function(event, ui) {
     //    // if tag is removed, need to delete from the db
     //    var patientId = $("#patient-id").val();
     //    var adaptEquipName = ui.tagLabel;
     //    $.post(SITE_URL, {
     //      page: "PatientInfo",
     //      action: "deleteItem",
     //      patient: patientId,
     //      name: adaptEquipName,
     //      type: "adapt_equip"
     //      }, function (e) {
     //        console.log(e);
     //      }, "json"
     //    );
     //  }
     // });


     // $("#supplements").tagit({
     // fieldName: "supplements[]",
     //  availableTags: fetchOptions("Supplement"),
     //    showAutocompleteOnFocus: false,
     //    caseSensitive: false,
     //    allowSpaces: true,

     //    beforeTagRemoved: function(event, ui) {
     //    // if tag is removed, need to delete from the db
     //    var patientId = $("#patient-id").val();
     //    var supplementName = ui.tagLabel;
     //    console.log(patientId);
     //    $.post(SITE_URL, {
     //      page: "PatientInfo",
     //      action: "deleteItem",
     //      patient: patientId,
     //      name: supplementName,
     //      type: "supplement"
     //      }, function (e) {
     //        console.log(e);
     //      }, "json"
     //    );
     //  }
     // });


     // $("#breakfast_specialrequest").tagit({
     //  fieldName: "breakfast_specialrequest[]",
     //  availableTags: fetchOptions("SpecialReq"),
     //  showAutocompleteOnFocus: false,
     //  caseSensitive: false,
     //  allowSpaces: true,
     //  beforeTagRemoved: function(event, ui) {
     //      // if tag is removed, need to delete from the db
     //      var patientId = $("#patient-id").val();
     //      var specialRequestName = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: specialRequestName,
     //        meal: 1,
     //        type: "special_request"
     //        }, function (e) {
     //          console.log(e);
     //        }, "json"
     //      );
     //  }

     // });

     // $("#lunch_specialrequest").tagit({
     //  fieldName: "lunch_specialrequest[]",
     //  availableTags: fetchOptions("SpecialReq"),
     //  showAutocompleteOnFocus: false,
     //  caseSensitive: false,
     //  allowSpaces: true,
     //  beforeTagRemoved: function(event, ui) {
     //      // if tag is removed, need to delete from the db
     //      var patientId = $("#patient-id").val();
     //      var specialRequestName = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: specialRequestName,
     //        meal: 2,
     //        type: "special_request"
     //        }, function (e) {
     //          console.log(e);
     //        }, "json"
     //      );
     //  }

     // });

     // $("#dinner_specialrequest").tagit({
     //  fieldName: "dinner_specialrequest[]",
     //  availableTags: fetchOptions("SpecialReq"),
     //  showAutocompleteOnFocus: false,
     //  caseSensitive: false,
     //  allowSpaces: true,
     //  beforeTagRemoved: function(event, ui) {
     //      // if tag is removed, need to delete from the db
     //      var patientId = $("#patient-id").val();
     //      var specialRequestName = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: specialRequestName,
     //        meal: 3,
     //        type: "special_request"
     //        }, function (e) {
     //          console.log(e);
     //        }, "json"
     //      );
     //  }

     // });


     // $("#breakfast_beverages").tagit({
     //  fieldName: "breakfast_beverages[]",
     //  availableTags: fetchOptions("Beverage"),
     //  showAutocompleteOnFocus: false,
     //  caseSensitive: false,
     //  allowSpaces: true,
     //  beforeTagRemoved: function(event, ui) {
     //      // if tag is removed, need to delete from the db
     //      var patientId = $("#patient-id").val();
     //      var beverageName = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: beverageName,
     //        type: "beverage",
     //        meal: 1
     //        }, function (e) {
     //          console.log(e);
     //        }, "json"
     //      );
     //  }

     // });

     // $("#lunch_beverages").tagit({
     //  fieldName: "lunch_beverages[]",
     //  availableTags: fetchOptions("Beverage"),
     //  showAutocompleteOnFocus: false,
     //  caseSensitive: false,
     //  allowSpaces: true,
     //  beforeTagRemoved: function(event, ui) {
     //      // if tag is removed, need to delete from the db
     //      var patientId = $("#patient-id").val();
     //      var beverageName = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: beverageName,
     //        type: "beverage",
     //        meal: 2
     //        }, function (e) {
     //          console.log(e);
     //        }, "json"
     //      );
     //  }

     // });


     // $("#dinner_beverages").tagit({
     //  fieldName: "dinner_beverages[]",
     //  availableTags: fetchOptions("Beverage"),
     //  showAutocompleteOnFocus: false,
     //  caseSensitive: false,
     //  allowSpaces: true,
     //  beforeTagRemoved: function(event, ui) {
     //      // if tag is removed, need to delete from the db
     //      var patientId = $("#patient-id").val();
     //      var beverageName = ui.tagLabel;
     //      $.post(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "deleteItem",
     //        patient: patientId,
     //        name: beverageName,
     //        type: "beverage",
     //        meal: 3
     //        }, function (e) {
     //          console.log(e);
     //        }, "json"
     //      );
     //  }

     // });

     //    $("#snackAM").tagit({
     //      fieldName: "am[]",
     //      availableTags: fetchOptions("Snack"),
     //      showAutocompleteOnFocus: false,
     //      caseSensitive: false,
     //      allowSpaces: true,

     //        beforeTagRemoved: function(event, ui) {
     //        // if tag is removed, need to delete from the db
     //        var patientId = $("#patient-id").val();
     //        var snackName = ui.tagLabel;
     //        $.post(SITE_URL, {
     //          page: "PatientInfo",
     //          action: "deleteItem",
     //          patient: patientId,
     //          name: snackName,
     //          type: "snack",
     //          time: "am"
     //          }, function (e) {
     //            console.log(e);
     //          }, "json"
     //        );
     //    }
     //    });

     //    $("#snackPM").tagit({
     //      fieldName: "pm[]",
     //      availableTags: fetchOptions("Snack"),
     //      showAutocompleteOnFocus: false,
     //      caseSensitive: false,
     //      allowSpaces: true,

     //        beforeTagRemoved: function(event, ui) {
     //        // if tag is removed, need to delete from the db
     //        var patientId = $("#patient-id").val();
     //        var snackName = ui.tagLabel;
     //        $.post(SITE_URL, {
     //          page: "PatientInfo",
     //          action: "deleteItem",
     //          patient: patientId,
     //          name: snackName,
     //          type: "snack",
     //          time: "pm"
     //          }, function (e) {
     //            console.log(e);
     //          }, "json"
     //        );
     //    }
     //    });

     //    $("#snackBedtime").tagit({
     //      fieldName: "bedtime[]",
     //      availableTags: fetchOptions("Snack"),
     //      showAutocompleteOnFocus: false,
     //      caseSensitive: false,
     //      allowSpaces: true,

     //        beforeTagRemoved: function(event, ui) {
     //        // if tag is removed, need to delete from the db
     //        var patientId = $("#patient-id").val();
     //        var snackName = ui.tagLabel;
     //        $.post(SITE_URL, {
     //          page: "PatientInfo",
     //          action: "deleteItem",
     //          patient: patientId,
     //          name: snackName,
     //          type: "snack",
     //          time: "bedtime"
     //          }, function (e) {
     //            console.log(e);
     //          }, "json"
     //        );
     //    }
     //    });


     //    function fetchOptions(type){
     //      var choices = "";
     //      var array = [];
     //      var runLog = function() {
     //        array.push(choices);
     //      };

     //      var options = $.get(SITE_URL, {
     //        page: "PatientInfo",
     //        action: "fetchOptions",
     //        type: type
     //        }, function(data) {
     //          $.each(data, function(key, value) {
     //            choices = value.name;
     //            runLog();
     //          });
     //        }, "json"
     //      );
     //      return array;
     //    }

     // });
</script>