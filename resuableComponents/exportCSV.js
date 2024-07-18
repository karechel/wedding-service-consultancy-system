document.getElementById('exportCSV').addEventListener('click', function() {
    let csvContent = "data:text/csv;charset=utf-8,";
    let rows;
    let fileName;

    if (document.querySelector("#bookingsTable")) {
        rows = document.querySelectorAll("#bookingsTable tr");
        fileName = "bookings.csv";
    } else if (document.querySelector("#clientsTable")) {
        rows = document.querySelectorAll("#clientsTable tr");
        fileName = "clients.csv";
    } else if (document.querySelector("#servicesTable")) {
        rows = document.querySelectorAll("#servicesTable tr");
        fileName = "services.csv";
    } else {
        alert('No table found for export.');
        return;
    }

    rows.forEach(row => {
        let rowData = [];
        row.querySelectorAll('th, td').forEach(cell => {
            rowData.push(cell.innerText);
        });
        csvContent += rowData.join(",") + "\r\n";
    });

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", fileName);
    document.body.appendChild(link); // Required for Firefox

    link.click();
    document.body.removeChild(link);
});
