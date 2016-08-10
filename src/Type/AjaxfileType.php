<?php

namespace Enrj\Type;

/*
 * Bundle d'upload pour Symfony2
 * https://github.com/bnbc/Symfony2-Upload-Ajax
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Options;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class AjaxfileType extends AbstractType
{

    public function __construct()
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
            'formData'     => array(
                'max_file_size'     => null,
                'accept_file_types' => null,
                'upload_folder'     => null,
                'image_versions'    => null,
            ),
            'multiple'          => false,
            'dropZone'          => true,
            'autoUpload'        => true,
            'dropZoneText'      => 'Glisser/déposer les fichiers ici',
            'callbackFunction'  => null,
        ));
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'formData'          => $options['formData'],
            'multiple'          => $options['multiple'],
            'dropZone'          => $options['dropZone'],
            'autoUpload'        => $options['autoUpload'],
            'dropZoneText'      => $options['dropZoneText'],
            'callbackFunction'  => $options['callbackFunction'],
        ));
    }


    public function getParent()
    {
        return  FormType::class;
    }

    public function getBlockPrefix()
    {
        return 'ajax_file';
    }
}