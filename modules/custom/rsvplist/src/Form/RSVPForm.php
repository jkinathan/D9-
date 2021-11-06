<?php
/**
 * @file
 * Contains \Drupal\rsvplist\Form\RSVPForm
 */

  namespace Drupal\rsvplist\Form;

  use Drupal\Core\Database\Database;
  use Drupal\Core\Form\Formbase;
  use Drupal\Core\Form\FormStateInterface;

 /**
  * Provides an RSVP Email Form
  */
  class RSVPForm extends Formbase{
    /**
     * (@inheritdoc)
     */
    public function getFormId(){
      return 'rsvplist_email_form';
    //   this is our id for this form, every form in drupal has an id
    }
    
    public function buildForm(array $form, FormStateInterface $form_state){
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;

        $form['email'] = array(
            '#title' => t('Email Address'),//the t is for translation to other languages
            '#type' => 'textfield',
            '#size' => 25,
            '#description' => t('We will send updates to the email address you provice'),
            '#required' => TRUE,
        );
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('RSVP'),
        );
        $form['nid'] = array(
            '#type' => 'hidden',
            '#value' => $nid,
        );

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        drupal_set_message(t('The Form is Working.'));
    }
  }
