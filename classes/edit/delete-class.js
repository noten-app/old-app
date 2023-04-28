function deleteClass() {
    const confirmation = confirm("Are you sure you want to delete this class?");
    if (confirmation) $.ajax({
        url: "./delete.php",
        type: "POST",
        data: { id: classID },
        success: function(data) {
            console.log(data);
            if (data == "success") location.assign("/classes/");
            else alert("There was an error deleting this class.");
        }
    });
}