// Social Media Sharing

document.getElementById("shareButton").addEventListener("click", async function() {

    if (navigator.share) {

        await navigator.share({
            title: "Green Leaf Cafe",
            text: "Visit Green Leaf Cafe",
            url: window.location.href
        });

    } else if (navigator.clipboard) {

        await navigator.clipboard.writeText(window.location.href);
        alert("Website link copied!");

    } else {

        window.prompt("Copy website link:", window.location.href);

    }
});