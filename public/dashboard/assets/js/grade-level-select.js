$(function () {
    // Initialize Select2 inputs
    $("#curricula, #grade_levels, #teacher_id").select2({
        allowClear: true,
        width: "100%",
        placeholder: "",
    });

    // Add the buttons
    if (!$("#select-all-grade-levels").length) {
        $("#grade_levels").closest(".input-group").after(`
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" id="select-all-grade-levels" class="btn btn-sm btn-primary me-2">
                        Select All
                    </button>
                    <button type="button" id="clear-all-grade-levels" class="btn btn-sm btn-secondary">
                        Clear All
                    </button>
                </div>
            `);
    }

    // When Select All clicked → select everything
    $(document).on("click", "#select-all-grade-levels", function () {
        const values = $("#grade_levels option")
            .map(function () {
                return $(this).val();
            })
            .get();

        $("#grade_levels").val(values).trigger("change");
    });

    // When Clear All clicked → unselect everything
    $(document).on("click", "#clear-all-grade-levels", function () {
        $("#grade_levels").val(null).trigger("change");
    });
});
