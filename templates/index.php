<?php
// TODO: Use variable for actual Nextcloud data and not 'data' literally

function print_login_header () {
?>
<table style="width:100%">
  <tr>
    <th><b>Time</b></th>
    <th><b>User</b></th>
    <th><b>Message</b></th>
    <th><b>IP</b></th>
  </tr>
<?php
}

function print_login_footer () {
?>
</table>
<?php
}

function print_login_row ($jsonData) {
?>
  <tr>
    <td><?php echo ($jsonData["time"]); ?></td>
    <td><?php echo ($jsonData["user"]); ?></td>
    <td><?php echo ($jsonData["message"]); ?></td>
    <td><?php echo ($jsonData["remoteAddr"]); ?></td>
  </tr>
<?php
}

function valid_login_message ($jsonData) {

    return ( (str_starts_with($jsonData["message"], "Login")) or (str_starts_with($jsonData["message"], "Logout")) );

}

function get_all_lines($audit_log_file_handle) {
    while (!feof($audit_log_file_handle)) {
        yield fgets($audit_log_file_handle);
    }
}

function get_log_filename () {

    $auditType = $config->getSystemValueString('log_type_audit', 'file');
    $logFile = $config->getSystemValueString('logfile_audit', '');

    if ($auditType === 'file' && !$logFile) {
        $default = $config->getSystemValue('datadirectory', \OC::$SERVERROOT . '/data') . '/audit.log';
        // Legacy way was appconfig, now it's paralleled with the normal log config
        $logFile = $config->getAppValue('admin_audit', 'logfile', $default);
    }

    return ($logFile);

}

$audit_log_filename = get_log_filename();
$audit_log_file_handle = fopen($audit_log_filename, 'r');

print_login_header();

foreach (get_all_lines($audit_log_file_handle) as $line) {
    $jsonString = $line;
    $jsonData = json_decode($jsonString, true);
    if (valid_login_message($jsonData)) {
        print_login_row($jsonData);
    }
}
print_login_footer();

fclose($audit_log_file_handle);
?>
