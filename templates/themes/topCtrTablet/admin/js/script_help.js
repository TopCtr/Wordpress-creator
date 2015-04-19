
/**
 * @escription Create the help messages
 */
jQuery(document).ready(function($) {
    var entityName = "Casino ";
    var category = "Game Categories";
    var available_brands_content = "<h3>Available Brands Help</h3><p>To add brands to this list just:" + "<ol><li>Click " + entityName + " Reviews on the right pane.</li>" + "<li>Add " + entityName + " or edit one</li>" + "<li>On the " + category + " check the appropriate category</li>" + "</ol>" + "Don't forget to save!" + "</p>";
    var available_brands_help_options = {
        "content": available_brands_content,
        "position": {
            "edge": "left",
            "align": "center"
        } //,close: function() {}
    };
    $('#available_brands_help').pointer(available_brands_help_options);
    $('#available_brands_help').click(function() {
        $('#available_brands_help').pointer("open");
    });
    var brands_to_display_content = "<h3>Brands To Display Help</h3>" + "<p>Drag brands to this list and they show up on the table of the page by the same order like here.</p>";
    var brands_to_display_help_options = {
        "content": brands_to_display_content,
        "position": {
            "edge": "left",
            "align": "center"
        } //,close: function() {}
    };
    $('#brands_to_display_help').pointer(brands_to_display_help_options);
    $('#brands_to_display_help').click(function() {
        $('#brands_to_display_help').pointer("open");
    });
});