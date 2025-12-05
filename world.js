window.onload = function () {
    const lookupBtn = document.getElementById("lookup");
    const lookupCitiesBtn = document.getElementById("lookup-cities");
    const result = document.getElementById("result");
    const country = document.getElementById("country");

    // Lookup countries
    lookupBtn.addEventListener("click", function () {
        fetch(`world.php?country=${country.value}`)
            .then(response => response.text())
            .then(data => result.innerHTML = data);
    });

    // Lookup cities
    lookupCitiesBtn.addEventListener("click", function () {
        fetch(`world.php?country=${country.value}&lookup=cities`)
            .then(response => response.text())
            .then(data => result.innerHTML = data);
    });
};
