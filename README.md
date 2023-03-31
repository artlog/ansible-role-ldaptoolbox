Ldaptoolbox
===========

This role aims to deploy tools from the Ldap Toolbox (see ltb-project.org).

This was intiialy created to deploy Self-Service Password with Apache2 on Debian.

Work in progress on this rpm branch :
Deploy Self-Service Password and Service-Desk with Apache (httpd) on Redhat 9


Requirements
------------

VM installed with right operating system
internet access for repositories
accessible through ansible host if not same as VM.

Role Variables
--------------

### Self-Service Password

Defaults settings must be overrident to enable self-service password:

```
ldaptoolbox_ssp_enabled: true
```

Configuration to access LDAP server:

```
ldaptoolbox_ssp_ldap_settings:
	ldap_url: "'ldap://localhost'"
	ldap_starttls: false
	ldap_binddn: "'cn=manager,dc=example,dc=com'"
	ldap_bindpw: "'secret'"
	ldap_base: "'dc=example,dc=com'"
	ldap_login_attribute: "'uid'"
	ldap_fullname_attribute: "'cn'"
	ldap_filter: "'(&(objectClass=person)($ldap_login_attribute={login}))'"
```

For more Self-Service Password Settings, please refer to [upstream documentation](https://self-service-password.readthedocs.io/en/latest/).

### Service-Desk

By default service desk access is protected by basic auth only members in {{ ldaptoolbox_sd_admin_group }} ,{{ ldaptoolbox_sd_organisation_ldap_base }} are allowed to use it.

```
ldaptoolbox_sd_ldap_settings:
	ldap_url: "'ldap://localhost'"
	ldap_starttls: false
	ldap_binddn: "'cn=manager,dc=example,dc=com'"
	ldap_bindpw: "'secret'"
	ldap_base: "'dc=example,dc=com'"
	ldap_login_attribute: "'uid'"
	ldap_fullname_attribute: "'cn'"
	ldap_filter: "'(&(objectClass=person)($ldap_login_attribute={login}))'"
ldaptoolbox_sd_admin_group: "cn=support"
```

#### Logo

logo should be in files/images/ltb-logo.png

default logo can be foudn in project self-service-password.worteks/docs/images/ltb-logo.png

Dependencies
------------

smarty should be installed manualy
Did use this quite old : https://rhel.pkgs.org/8/remi-x86_64/php-Smarty-3.1.33-1.el8.remi.noarch.rpm.html


Example Playbook
----------------

Example for deploying Self-Service Password:

```
################################################################################
# self-service-password installation
################################################################################
---
- hosts: ldapconsumer
  become: true
  vars_files:
    - credentials-vault.yml
    - vars/ecn_vars.yml
  roles:
    - role: ansible-role-ldaptoolbox
      ldaptoolbox_ssp_enabled: true
      ldaptoolbox_ssp_ldap_settings:
        ldap_url: "'ldap://localhost'"
        ldap_starttls: false
        ldap_binddn: "{{ ldaptoolbox_openldap_database_olcRootDN }}"
        ldap_bindpw: "'secret'"
        ldap_base: "{{ ldaptoolbox_openldap_suffix }}"
        ldap_login_attribute: "'uid'"
        ldap_fullname_attribute: "'cn'"
        ldap_filter: "'(&(objectClass=person)($ldap_login_attribute={login}))'"
      ldaptoolbox_ssp_mail_settings: {}
      ldaptoolbox_ssp_ssl_key: "{{ ldaptoolbox_openldap_olcTLSCertificateKeyFile }}"
      ldaptoolbox_ssp_ssl_cert: "{{ ldaptoolbox_openldap_olcTLSCertificateFile }}"
```

and vars/ 

```
ldaptoolbox_ssp_server_name: "ssp.example.com"
ldaptoolbox_openldap_olcTLSCertificateFile: /etc/certs/example.com/example.com.pem
ldaptoolbox_openldap_olcTLSCertificateKeyFile: /etc/certs/example.com/example.com.key
```

Tweaks
------

Those are not yet fixed :

- selinux is not handled, lazzily used : setenforce permissive
- apache group execute and rights should be given for group /usr/share/self-service-password
- firewall access : firewallctl --add-service https

License
-------

GPLv3


Author Information
------------------

Mathieu Jourdan <m.jourdan@rennesmetropole.fr>
Philippe Lhary <philippe.lhardy@worteks.com>
