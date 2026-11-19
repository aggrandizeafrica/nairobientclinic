<?php
/* Nairobi ENT redesign – site data (menu, services, doctors, clinics). */
if (!defined('ABSPATH')) exit;

function nent_u($path) { return 'https://nairobientclinic.com' . $path; }
function nent_img($path) { return 'https://nairobientclinic.com/wp-content/uploads/' . $path; }

function nent_phone() { return '+254 721 391 465'; }
function nent_tel() { return 'tel:+254721391465'; }
function nent_book_url() { return nent_u('/appointment/'); }
function nent_whatsapp() { return 'https://wa.me/254725147392'; }

function nent_services() {
    return array(
        array('General ENT', '/solution/general-ent/', 'stethoscope', 'Diagnosis and treatment for everyday and complex ear, nose and throat conditions in adults and children.'),
        array('Hearing Centre', '/solution/hearing-centre/', 'ear', 'Hearing tests, tinnitus care, hearing aids and rehabilitation for every stage of life.'),
        array('Rhinology & Allergy', '/solution/rhinology-and-allergy/', 'wind', 'Sinus, nasal and allergy care to help you breathe freely again.'),
        array('Speech Pathology', '/solution/speech-pathology/', 'message', 'Assessment and therapy for speech, language and swallowing difficulties.'),
        array('Sleep Medicine', '/solution/sleep-medicine/', 'moon', 'Snoring, sleep apnoea, sleep studies and CPAP support.'),
        array('Head & Neck Surgery', '/solution/head-and-neck-surgery/', 'shield', 'Specialist surgery for head and neck conditions, including cancers.'),
        array('Voice Clinic', '/solution/voice-clinic/', 'mic', 'Care for hoarseness, voice strain and vocal cord problems.'),
        array('Laryngology', '/solution/laryngology/', 'activity', 'Expert care for the voice box, airway and swallowing.'),
    );
}

function nent_menu() {
    return array(
        array('label' => 'Services', 'mega' => 'services', 'cols' => array(
            'ENT Services' => array(
                array('General ENT', '/solution/general-ent/'),
                array('Rhinology & Allergy', '/solution/rhinology-and-allergy/'),
                array('Otology', '/solution/otology/'),
                array('Laryngology', '/solution/laryngology/'),
                array('Sleep Medicine', '/solution/sleep-medicine/'),
                array('Head & Neck Surgery', '/solution/head-and-neck-surgery/'),
                array('Voice Clinic', '/solution/voice-clinic/'),
                array('Speech Pathology', '/solution/speech-pathology/'),
            ),
            'Hearing & Balance' => array(
                array('Hearing Centre', '/solution/hearing-centre/'),
                array('Hearing Assessments', '/solution/hearing-assessments/'),
                array('Tinnitus Assessment', '/solution/tinnitus-assessment-and-management/'),
                array('Occupational Hearing Tests', '/solution/occupational-and-industrial-hearing-tests/'),
                array('Hearing Aids & Rehabilitation', '/solution/hearing-aids-and-rehabilitation/'),
                array('Vestibular Assessment', '/solution/vestibular-assessment-and-rehabilitation/'),
            ),
            'Voice & Speech Therapy' => array(
                array('Speech & Language Therapy', '/solution/speech-and-language-therapy/'),
                array('Adult Speech Therapy', '/solution/speech-and-language-therapy-adult/'),
                array('Voice Therapy', '/solution/voice-therapy/'),
                array('Swallowing', '/solution/swallowing/'),
                array('Surgical Services', '/solution/surgical-services/'),
            ),
        )),
        array('label' => 'Conditions', 'mega' => 'conditions', 'cols' => nent_conditions()),
        array('label' => 'Our Team', 'items' => array(
            array('ENT Surgeons', '/doctors/'),
            array('ENT Staff', '/ent-staff/'),
            array('About Us', '/about-us/'),
            array('Patient Testimonials', '/patient-testimonials/'),
            array('Insurance', '/insurance/'),
        )),
        array('label' => 'Clinics', 'url' => '/clinics/'),
        array('label' => 'Media', 'items' => array(
            array('Blog', '/blog/'),
            array('Events', '/events/'),
            array('Gallery', '/gallery/'),
            array('Videos', 'https://www.youtube.com/@nairobientclinic1987'),
        )),
        array('label' => 'Contact', 'url' => '/contact-us/'),
    );
}

function nent_conditions() {
    return array(
        'Ear & Hearing' => array(
            array('Ear Infections', '/ear-infections-acute-otitis-media-in-children/'),
            array('Tinnitus', '/tinnitus/'),
            array('Ear Wax Build-up', '/ear-wax-build-up/'),
            array('Hearing Loss', '/hearing-loss/'),
            array('Age-Related Hearing Loss', '/age-related-hearing-loss/'),
            array('Perforated Ear Drum', '/perforated-ear-drum/'),
            array('Outer Ear Infection', '/outer-ear-infection-otitis-externa/'),
            array('Hearing Aids', '/hearing-aids/'),
        ),
        'Balance' => array(
            array('Dizziness & Vertigo', '/dizziness-and-vertigo/'),
            array('Positional Vertigo (BPPV)', '/positional-vertigo-bppv/'),
            array('Ménière’s Disease', '/menieres-disease/'),
            array('Vestibular Neuritis', '/vestibular-neuritis/'),
            array('Labyrinthitis', '/labyrinthitis/'),
        ),
        'Nose & Allergy' => array(
            array('Chronic Sinusitis', '/chronic-sinusitis/'),
            array('Acute Sinusitis', '/acute-sinusitis/'),
            array('Allergic Rhinitis', '/allergic-rhinitis-basics/'),
            array('Nosebleeds', '/nosebleeds/'),
            array('Nose Fracture', '/nose-fracture/'),
            array('Rinsing Your Nose', '/rinsing-out-your-nose/'),
        ),
        'Throat & Voice' => array(
            array('Sore Throat', '/sore-throat/'),
            array('Globus Sensation', '/globus-sensation/'),
            array('Laryngopharyngeal Reflux', '/laryngo-pharyngeal-reflux-lpr/'),
            array('Laryngitis', '/laryngitis/'),
        ),
        'Sleep' => array(
            array('Snoring in Adults', '/snoring-in-adults/'),
            array('Obstructive Sleep Apnoea', '/obstructive-sleep-apnea/'),
            array('Sleep Study', '/sleep-study/'),
            array('CPAP', '/cpap/'),
            array('Daytime Sleepiness', '/excessive-daytime-sleepiness/'),
        ),
        'Children' => array(
            array('Tonsillectomy & Adenoidectomy', '/tonsillectomy-and-adeniodectomy/'),
            array('Glue Ear', '/glue-ear-otitis-media-with-effusion/'),
            array('Grommets (Ear Tubes)', '/grommets-ear-tubes/'),
            array('Hearing Loss in Children', '/hearing-loss-in-children/'),
            array('Newborn Hearing Screening', '/screening-for-hearing-loss-in-newborns/'),
        ),
        'Head & Neck' => array(
            array('Head & Neck Cancer', '/head-and-neck-cancer/'),
            array('Cancer of the Larynx', '/cancer-of-the-larynx/'),
            array('Nasopharyngeal Cancer', '/nasopharyngeal-cancer/'),
            array('Oropharyngeal Cancer', '/oropharyngeal-cancer/'),
            array('Cancer of the Hypopharynx', '/cancer-of-the-hypopharynx/'),
        ),
        'Aesthetics' => array(
            array('Dermal Fillers', '/dermal-fillers/'),
            array('Botulinum Toxin', '/botulinum-toxin/'),
            array('Chemical Peel', '/chemical-peel/'),
            array('Preparing for Surgery', '/preparation-for-surgery/'),
        ),
    );
}

function nent_doctors() {
    return array(
        array('Prof. Isaac M. Macharia', 'Founder · ENT, Head & Neck Surgeon', '2020/11/Prof-Macharia-600x600.jpg', '/doctor/prof-isaac-m-macharia/'),
        array('Dr. Chimmy Omamo-Olende', 'Founder · ENT, Head & Neck Surgeon', '2025/09/Dr.-Chimmy-Omamo-Olende-600x600.png', '/doctor/dr-chimmy-omamo-olende/'),
        array('Dr. Samuel Nyagah', 'ENT Surgeon', '2025/09/Dr.-Samuel-Nyagah-600x600.png', '/doctor/dr-samuel-nyagah/'),
        array('Dr. Sophie Gitonga', 'ENT & Facial Aesthetic Surgeon', '2025/09/Dr.-Sophie-Gitonga-600x600.png', '/doctor/dr-sophie-gitonga/'),
        array('Dr. Grace Mwangi', 'ENT Surgeon', '2025/09/Dr.-Grace-Mwangi-600x600.png', '/doctor/dr-mwangi-grace/'),
        array('Dr. Ian Macharia', 'ENT Surgeon', '2025/09/Dr.-Ian-Macharia-600x600.png', '/doctor/dr-ian-macharia/'),
        array('Dr. Caroline Muturi', 'ENT, Head & Neck Surgeon', '2024/10/Caroline-Muturi-600x600.jpg', '/doctor/dr-caroline-muturi/'),
        array('Dr. Ngugi', 'ENT Surgeon', '2025/12/Dr.-Ngugi-600x600.png', '/doctor/dr-ngugi/'),
    );
}

function nent_clinics() {
    return array(
        array('Nairobi Hospital Clinic', 'Anderson Building, 5th Floor, Nairobi', '+254 721 391 465', 'tel:+254721391465', '/clinics/nairobi-hospital-clinic/', 'Main clinic'),
        array('Aga Khan University Hospital', 'Doctors’ Plaza, 1st Floor, Room 110', '+254 721 391 404', 'tel:+254721391404', '/clinics/aga-khan-university-hospital-clinic/', 'Parklands'),
        array('Greenspan Mall Clinic', 'Greenspan Mall, 2nd Floor, Donholm', '+254 725 021 315', 'tel:+254725021315', '/clinics/greenspan-mall-clinic-donholm/', 'Eastlands'),
        array('Eastleigh Clinic', 'Business Bay Square (BBS Mall), 1st Floor', '+254 114 708 324', 'tel:+254114708324', '/clinics/eastleigh-clinic/', 'Eastleigh'),
        array('AAR Hospital', 'Kiambu Road, Nairobi', '+254 769 724 434', 'tel:+254769724434', '/clinics/aar-hospital/', 'Kiambu Road'),
        array('Kisumu Clinic', 'Mega City Mall, Ground Floor, Kisumu', '+254 739 167 915', 'tel:+254739167915', '/clinics/kisumu-clinic-mega-city/', 'Kisumu'),
    );
}

function nent_testimonials() {
    return array(
        array('The ENT clinic provided outstanding care for my throat condition. The doctor explained everything clearly, and the treatment was effective.', 'Peter S.'),
        array('From the first consultation, the specialist made me feel comfortable. My nose surgery went smoothly, and the follow-up care was excellent.', 'Robert E.'),
        array('The doctor was thorough and patient, taking time to address all my concerns. My hearing has improved drastically after treatment.', 'Emily B.'),
        array('I feel very blessed to have this clinic in our community. All the nurses and doctors were very caring and professional.', 'Mary S.'),
        array('My hearing loss was addressed with a personalised plan, and I’ve experienced noticeable improvement. Care that exceeded my expectations.', 'Sarah D.'),
    );
}
