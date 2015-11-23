<?php

class ThemeHouse_UserPromotions_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/UserPromotions/Extend/XenForo/ControllerAdmin/UserGroupPromotion.php' => 'b41d9fba19ecbe1e83efc4b1fa7ba34f',
                'library/ThemeHouse/UserPromotions/Extend/XenForo/DataWriter/UserGroupPromotion.php' => 'c74b7874e1cac551a14ea491428f5016',
                'library/ThemeHouse/UserPromotions/Extend/XenForo/Deferred/UserGroupPromotion.php' => '47a38b1bfb808f28149e76e9e6f70d04',
                'library/ThemeHouse/UserPromotions/Extend/XenForo/Model/AdminNavigation.php' => 'f8f54c3e1795511a8764d513f11e7b0e',
                'library/ThemeHouse/UserPromotions/Extend/XenForo/Model/UserChangeTemp.php' => '5b3c8f1fbead566af213574e7b521aab',
                'library/ThemeHouse/UserPromotions/Extend/XenForo/Model/UserGroupPromotion.php' => '8822a408d452f8068a75bc1649bf87be',
                'library/ThemeHouse/UserPromotions/Extend/XenForo/Route/PrefixAdmin/UserGroupPromotions.php' => '9afd8865598db5eedb767dea5a6220e4',
                'library/ThemeHouse/UserPromotions/Install/Controller.php' => '0e249c2fbeb0b9e2d7b75e567fc722c4',
                'library/ThemeHouse/UserPromotions/Listener/LoadClass.php' => '5a174717a605334a49700cd1a689c815',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
            ));
    }
}