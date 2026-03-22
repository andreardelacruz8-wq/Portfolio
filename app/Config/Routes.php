<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home route (handles both admin and guest based on session)
$routes->get('/', 'Home::index');

// Contact form
$routes->post('contact/send', 'Contact::send');

// Login routes
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/attemptLogin', 'Admin::attemptLogin');
$routes->post('admin/guestLogin', 'Admin::guestLogin');
$routes->get('admin/logout', 'Admin::logout');

// Viewer routes
$routes->get('viewer/register', 'ViewerAuth::register');
$routes->post('viewer/attemptRegister', 'ViewerAuth::attemptRegister');
$routes->get('viewer/logout', 'ViewerAuth::logout');

// Guest route (explicit guest access)
$routes->get('guest', 'Home::guest');

// Public certification routes (no login required)
$routes->get('certification/(:num)', 'Home::getCertification/$1');
$routes->get('certifications/all', 'Home::getAllCertifications');
$routes->get('certifications/issuer/(:any)', 'Home::getCertificationsByIssuer/$1');
$routes->get('certifications/search', 'Home::searchCertifications');
$routes->get('certifications/featured/(:num)', 'Home::getFeaturedCertifications/$1');

// Certification CRUD routes for direct admin access (non-API)
$routes->get('admin/get-certification/(:num)', 'Admin::getCertification/$1');
$routes->post('admin/save-certification', 'Admin::saveCertification');
$routes->post('admin/delete-certification', 'Admin::deleteCertification');
$routes->post('admin/upload-certification-pdf', 'Admin::uploadCertificationPdf');

// Admin CMS API Routes
$routes->group('api/admin', ['filter' => 'login'], function($routes) {
    // Hobbies
    $routes->get('hobbies', 'AdminCMS::getHobbies');
    $routes->post('hobbies/add', 'AdminCMS::addHobby');
    $routes->post('hobbies/update/(:num)', 'AdminCMS::updateHobby/$1');
    $routes->delete('hobbies/delete/(:num)', 'AdminCMS::deleteHobby/$1');
    
    // Projects
    $routes->get('projects', 'AdminCMS::getProjects');
    $routes->post('projects/add', 'AdminCMS::addProject');
    $routes->post('projects/update/(:num)', 'AdminCMS::updateProject/$1');
    $routes->delete('projects/delete/(:num)', 'AdminCMS::deleteProject/$1');
    
    // Special Skills
    $routes->get('special-skills', 'AdminCMS::getSpecialSkills');
    $routes->post('special-skills/add', 'AdminCMS::addSpecialSkill');
    $routes->post('special-skills/update/(:num)', 'AdminCMS::updateSpecialSkill/$1');
    $routes->delete('special-skills/delete/(:num)', 'AdminCMS::deleteSpecialSkill/$1');
    
    // Skills
    $routes->post('skills/add', 'AdminCMS::addSkill');
    $routes->post('skills/update/(:num)', 'AdminCMS::updateSkill/$1');
    $routes->delete('skills/delete/(:num)', 'AdminCMS::deleteSkill/$1');
    
    // Education
    $routes->get('education', 'AdminCMS::getEducation');
    $routes->post('education/add', 'AdminCMS::addEducation');
    $routes->post('education/update/(:num)', 'AdminCMS::updateEducation/$1');
    $routes->delete('education/delete/(:num)', 'AdminCMS::deleteEducation/$1');
    
    // Work Experience
    $routes->get('work-experience', 'AdminCMS::getWorkExperience');
    $routes->post('work-experience/add', 'AdminCMS::addWorkExperience');
    $routes->post('work-experience/update/(:num)', 'AdminCMS::updateWorkExperience/$1');
    $routes->delete('work-experience/delete/(:num)', 'AdminCMS::deleteWorkExperience/$1');
    
    // Soft Skills
    $routes->get('soft-skills', 'AdminCMS::getSoftSkills');
    $routes->post('soft-skills/add', 'AdminCMS::addSoftSkill');
    $routes->post('soft-skills/update/(:num)', 'AdminCMS::updateSoftSkill/$1');
    $routes->delete('soft-skills/delete/(:num)', 'AdminCMS::deleteSoftSkill/$1');
    
    // Certifications API routes
    $routes->get('certifications', 'AdminCMS::getCertifications');
    $routes->post('certifications/add', 'AdminCMS::addCertification');
    $routes->post('certifications/update/(:num)', 'AdminCMS::updateCertification/$1');
    $routes->delete('certifications/delete/(:num)', 'AdminCMS::deleteCertification/$1');
    $routes->post('certifications/upload-pdf', 'AdminCMS::uploadCertificationPdf');
});