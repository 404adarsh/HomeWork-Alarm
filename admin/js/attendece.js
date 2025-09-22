function saveAttendance() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var attendanceData = {};

    checkboxes.forEach(function(checkbox) {
        var student = checkbox.parentNode.parentNode.cells[0].innerText;
        var day = checkbox.parentNode.cellIndex;
        var checked = checkbox.checked;

        if (!attendanceData[student]) {
            attendanceData[student] = {};
        }

        attendanceData[student][day] = checked;
    });

    // Send attendance data to server using AJAX (not implemented in this example)
    console.log(attendanceData); // Replace with AJAX call to server
    alert("Attendance saved successfully!"); // Replace with appropriate feedback
}
