$(document).ready(() => {
    $(document).on('submit', '#delete', function () {

        //Post data from form
        var del = confirm("Are you sure you want to delete this step?");
        if (del == true) {
            $.post("../processes/ChecklistDelete.php", $(this).serialize())
                .done(function (data) {
                    window.location.replace("../views/ChecklistSearch.php?deleted");
                }).done(function () {
                    toastr.options.timeOut = 3000;
                    toastr.warning('Checklist Deleted');
                });
        }
        return false;
    });
});