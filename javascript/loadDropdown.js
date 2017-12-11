$(document).ready(loadJSON());

        function loadJSON() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'data/juniorcolleges.json', true);

            xhr.onload = function() {
                if(this.status == 200) {
                   var text = JSON.parse(this.responseText);
                   
                   var options = {
                        data: [],

                        list: {
                            maxNumberOfElements: 10,
                            match: {
                                enabled: true
                            },

                            onChooseEvent: function() {
                                var index = $("#search-college").getSelectedItemData();
                    
                                $("#hcollege").val(index).trigger("change");
                            }

	                    }
                    };

                    for(var i in text) {
                        options.data.push(text[i].FIELD2 +"");
                    }

                    console.log(options);

                    $("#search-college").easyAutocomplete(options);
                   
                    
                }
            }
            xhr.send();
        }