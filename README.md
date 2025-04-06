### Plugin Name: Simple Form
Text Domain: SF

### Shortcode Support
Added shortcodes support for both of the form and entry display.
```
[form_shortcode form_title="Form Title Here"]
[form_entry_display block_title="Entry Table Title"]
```

These documentation can be found on the plugin settings `SF Settings - Dashboard menu`.

### AJAX Form
The form gets submitted via AJAX and it gets replaced with a thank-you message.

### Pagination
The entries pagination also works with AJAX. The `posts_per_page` parameter can be changed from here.
```
Dashboard -> Settings -> Reading.
```

### Mail Configuration
The mail (to email address), message body and the success message can be changed from the plugin `Settings -> Options` page.

### Custom Database Table
To save the form data, a database table ({wp_prefix}sf_entry).

### Translation Friendly
This plugin has been made translation friendly. And I've given the Italian language support from the plugin.

### Message Pattern
On the message pattern field of plugin settings, user can use the form fields as `%field_id%` anywhere so that they can decorate the message how they want.

### Form Validation
Form has been validated via JS.

### Mail Function
This plugin sends the mail to both sender and recipent email address. Have used the default mail() function.

### Visibility
The form entries are only visible for admin users, for non-admin users, it will show a not-authorized message.
