const weddingDate = new Date(2024, 6, 9, 0, 0, 0);

function updateCountdown() {
    const currentTime = new Date();
    const difference = weddingDate - currentTime;

    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

    document.getElementById('countdown').innerHTML = `
        <div>${days} <span>days</span></div>
        <div>${hours} <span>hours</span></div>
        <div>${minutes} <span>minutes</span></div>
        <div>${seconds} <span>seconds</span></div>
    `;

    // Update countdown every second
    setTimeout(updateCountdown, 1000);
}

// Initial call to update countdown
updateCountdown();

// Handle RSVP form submission
document.getElementById('rsvpForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const name = document.querySelector('#rsvpForm input[type="text"]').value;
    const email = document.querySelector('#rsvpForm input[type="email"]').value;
    const message = document.querySelector('#rsvpForm textarea').value;

    // Perform form submission logic (e.g., send data to server)
    console.log(`RSVP submitted: Name - ${name}, Email - ${email}, Message - ${message}`);
}); // Function to generate and download personalized PDF invitation

document.getElementById('downloadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get user's name from input
    const userName = document.getElementById('userName').value.trim();

    if (userName) {
        // AJAX request to generate and download PDF
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'generate_pdf.php', true);
        xhr.responseType = 'blob'; // Receive response as a Blob

        // Set up a handler for the response
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Create a temporary anchor element to trigger the download
                const blob = new Blob([xhr.response], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `Wedding_Invitation_${userName}.pdf`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        };

        // Set up the request data (user's name)
        const formData = new FormData();
        formData.append('userName', userName);

        // Send the request
        xhr.send(formData);
    } else {
        alert('Please enter your name before downloading.');
    }
}); // Initialize Firebase