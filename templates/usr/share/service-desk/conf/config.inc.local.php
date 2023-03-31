<?php
# Managed by Ansible

# LDAP Settings
{% for key, value in ldaptoolbox_sd_ldap_settings.items() %}
${{ key }} = "{{ value }}";
{% endfor %}

$display_items = array('identifier', 'firstname', 'lastname', 'title', 'businesscategory', 'employeenumber', 'employeetype', 'mail', 'mailquota', 'phone', 'mobile', 'fax', 'postaladdress', 'street', 'postalcode', 'l', 'state', 'organizationalunit', 'organization');

# Language
$lang ="fr";
$date_specifiers = "%Y-%m-%d %H:%M:%S (%Z)";

# Graphics
# Customization
{% for key, value in ldaptoolbox_sd_customization_settings.items() %}
${{ key }} = "{{ value }}";
{% endfor %}

# $logout_link = "https://auth. ...";

?>
