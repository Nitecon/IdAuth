<?php

namespace IdAuth\Forms;

use Zend\Form\Annotation;

/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("User")
 */
class Login
{

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Username:"})
     * @Annotation\Attributes({"class":"form-control"})
     */
    public $username;

    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Password:"})
     * @Annotation\Attributes({"class":"form-control"})
     */
    public $password;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Login","class":"btn btn-block btn-primary btn-default"})
     */
    public $submit;

}
