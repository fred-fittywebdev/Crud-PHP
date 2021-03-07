let type = document.getElementsByTagName('span');
let color = document.getElementById('span').value;

for (const span of type) {
    if (span.innerText === "Aventure") {
        span.style.backgroundColor = 'green';
    } else if (span.innerText === "Sports") {
        span.style.backgroundColor = 'blue';
    } else if (span.innerText === "RPG") {
        span.style.backgroundColor = 'brown';
    } else if (span.innerText === "Simulation") {
        span.style.backgroundColor = 'pink';
    } else if (span.innerText === "Plateforme") {
        span.style.backgroundColor = 'red';
    } else if (span.innerText === "Gestion") {
        span.style.backgroundColor = 'black';
    } else {
        span.style.backgroundColor = 'salmon';
    }
}

function cancelModifications(event) {
    event.preventDefault();
    document.location.href = "index.php";
}