<?php

require_once 'lastactivitydate.civix.php';
// phpcs:disable
use Civi\Api4\Activity;
use CRM_Lastactivitydate_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function lastactivitydate_civicrm_config(&$config) {
  _lastactivitydate_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function lastactivitydate_civicrm_xmlMenu(&$files) {
  _lastactivitydate_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function lastactivitydate_civicrm_install() {
  _lastactivitydate_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function lastactivitydate_civicrm_postInstall() {
  _lastactivitydate_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function lastactivitydate_civicrm_uninstall() {
  _lastactivitydate_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function lastactivitydate_civicrm_enable() {
  _lastactivitydate_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function lastactivitydate_civicrm_disable() {
  _lastactivitydate_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function lastactivitydate_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _lastactivitydate_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function lastactivitydate_civicrm_managed(&$entities) {
  _lastactivitydate_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function lastactivitydate_civicrm_caseTypes(&$caseTypes) {
  _lastactivitydate_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function lastactivitydate_civicrm_angularModules(&$angularModules) {
  _lastactivitydate_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function lastactivitydate_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _lastactivitydate_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function lastactivitydate_civicrm_entityTypes(&$entityTypes) {
  _lastactivitydate_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function lastactivitydate_civicrm_themes(&$themes) {
  _lastactivitydate_civix_civicrm_themes($themes);
}

/**
 * Implements hook_civicrm_summary().
 */
function lastactivitydate_civicrm_summary($contactID, &$content, &$contentPlacement) {
  $contentPlacement = CRM_Utils_Hook::SUMMARY_ABOVE;

  $activity = Activity::get()
    ->addSelect('contact.contact_type:name', 'activity_type_id:label', 'activity_date_time')
    ->addJoin('Contact AS contact', 'INNER', 'ActivityContact')
    ->addWhere('contact.id', '=', $contactID)
    ->addOrderBy('activity_date_time', 'DESC')
    ->setLimit(1)
    ->execute()
    ->getArrayCopy()[0];

  $date = CRM_Utils_Date::formatDateOnlyLong($activity['activity_date_time']);
  $activityString = "Most recent activity: {$activity['activity_type_id:label']} - {$date}";

  $content = $activityString;
}
