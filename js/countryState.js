// Function to populate the country dropdown
function populateCountryDropdown() {
    var countryDropdown = document.getElementById("country");

    // Replace 'your_username' with your Geonames API username
    var apiUrl = "http://api.geonames.org/searchJSON?featureCode=PCLI&username=CWeyK&maxRows=200&style=long";

    // Make the API request
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Extract country names from the response
            var countries = data.geonames;

            // Clear the existing options
            countryDropdown.innerHTML = "";

            // Add a default option
            var defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "Country";
            countryDropdown.appendChild(defaultOption);

            // Sort countries alphabetically by country name
            countries.sort((a, b) => a.countryName.localeCompare(b.countryName));

            // Add country names to the dropdown
            countries.forEach(country => {
                var option = document.createElement("option");
                option.value = country.countryName; // Use country name as the value
                option.setAttribute('data-geoname-id', country.geonameId); // Store geonameId in data attribute
                option.textContent = country.countryName; // Display country name
                countryDropdown.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error fetching countries:", error);
        });
}

// Function to get states based on the selected country
function getStates(geonameId) {
    var stateDropdown = document.getElementById("state");

    var apiUrl = `http://www.geonames.org/childrenJSON?geonameId=${geonameId}&style=long`;
    console.log(apiUrl);
    // Make the API request
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Extract state names from the response
            var states = data.geonames;

            // Clear the existing options
            stateDropdown.innerHTML = "";



            // If there are no states, add the country as the state
            if (states.length === 0) {
                // Add a default option
                var defaultOption = document.createElement("option");
                defaultOption.value = "No States";
                defaultOption.textContent = "No States";
                stateDropdown.appendChild(defaultOption);
            } else {
                 // Add a default option
                 var defaultOption = document.createElement("option");
                 defaultOption.value = "";
                 defaultOption.textContent = "State";
                 stateDropdown.appendChild(defaultOption);

                 // Sort states alphabetically by country name
                states.sort((a, b) => a.name.localeCompare(b.name));
                // Add state names to the dropdown
                states.forEach(state => {     
                    var option = document.createElement("option");
                    option.value = state.name; // Use state name as the value
                    option.textContent = state.name; // Display state name
                    stateDropdown.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error("Error fetching states:", error);
        });
}

// Call the function to populate the country dropdown on page load
window.onload = function () {
    populateCountryDropdown();
};
