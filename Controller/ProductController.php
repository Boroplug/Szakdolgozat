<?php

namespace App\Controller;

use App\Model\ProductDao;
use App\Model\Cart;
use App\Model\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



require 'emailincludes/PHPMailer.php';
require 'emailincludes/SMTP.php';
require 'emailincludes/Exception.php';


use Twig\Environment;
use Twig\Loader\FilesystemLoader;








class ProductController implements ICrudController
{
    public function mainproductslist()
    {
        $cart = Cart::getCart();
        $data = $cart->getContents();
        $maindata = ProductDao::mainproductsall();
        $twig = (new CartController())->setTwigEnvironment();

        echo $twig->render('pages/mainpage.html.twig', ['allproduct' => $maindata, 'cart' => $data]);
    }
    public function sizelist()
    {


        $maindata = ProductDao::sizeall();
        $twig = (new CartController())->setTwigEnvironment();

        echo $twig->render('pages/openProduct.html.twig', ['sizedata' => $maindata]);
    }
    public function adidasproductslist()
    {
        $cart = Cart::getCart();
        $data = $cart->getContents();
        $data2 = ProductDao::adidasserachoptionsall();
        $adidasdata = ProductDao::mainproductsall();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/adidaspage.html.twig', ['allproductadidas' => $adidasdata, 'filterOptions' => $data2, 'cart' => $data]);
    }
    public function nikeproductslist()
    {
        $cart = Cart::getCart();
        $data = $cart->getContents();
        $nikedata = ProductDao::mainproductsall();
        $data2 = ProductDao::nikeserachoptionsall();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/nikepage.html.twig', ['allproductnike' => $nikedata, 'filterOptions' => $data2, 'cart' => $data]);
    }
    public function login()
    {
        $data = ProductDao::loginpageall();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/loginpage.html.twig', ['loginAll' => $data]);
    }


    public function openByIdAll($req)
    {
        $cart = Cart::getCart();
        $data = $cart->getContents();
        $id = $req->params[0];


        $maindata = ProductDao::mainproductsall();


        $sizedata = ProductDao::sizeall();

        $twig = (new ProductController())->setTwigEnvironment();
        $Data = ProductDao::openById($id);




        if (User::isLoggedIn()) {
            if ($Data) {
                if ($req->reqMethod == "POST") {
                    $body = $req->getBody();
                    $id = $body["id"];

                    $quantity = $body["quantity"];
                    $cart = Cart::getCart();
                    $cart->addProductById($id, $quantity);

                    return Header("Location: /openProduct/$id");
                }
                $rendelhetszid = "cartEffect";
                $rendelhetsz = "Kosárba";
                echo $twig->render('pages/openProduct.html.twig', ['openProduct' => $Data, 'cart' => $cart, 'cart' => $data, 'sizedata' => $sizedata, 'kosarba' => $rendelhetsz, 'maindatas' => $maindata,]);
            } else {
                $rendelhetszid = "";
                echo $twig->render('404.html.twig');
            }
        } else {

            $rendelhetsz = "Jelentkezzen be";
            echo $twig->render('pages/openProduct.html.twig', ['openProduct' => $Data, 'sizedata' => $sizedata, 'kosarba' => $rendelhetsz,]);
            
        }
    }

    //-----------------------------------------------------------------------------------------
    public function profil()
    {

        $cart = Cart::getCart();
        $dataprice = $cart->getContents();
        $orderdata = ProductDao::userOrders();
        $varosok = ProductDao::varosok();
        $adress = ProductDao::adress();
        $data = ProductDao::profilpageall();

        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/userprofile.html.twig', ['varosok' => $varosok, 'profilData' => $data, 'cart' => $dataprice, 'ordersData' => $orderdata, 'adress' => $adress]);
    }


    public function userordersList()
    {



        $orderdata = ProductDao::userOrders();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/userprofile.html.twig', ['ordersData' => $orderdata]);
    }

    //----------------Edit------------------------------------------------------

    public function updateAdress()
    {
        if (isset($_POST['save'])) {
            ProductDao::updateAddress();
            header('Location: /profilData');
            exit;
        }
    }
    //--------------Delete--------------------------
    public function openDelete()
    {



        $orderdata = ProductDao::profildelete();
        $twig = (new ProductController())->setTwigEnvironment();
        header('Location: /logout');
    }

    public function profilDelete()
    {


        if (isset($_POST['delete'])) {
            ProductDao::profildelete();
            header('Location: /login');
        }
    }





    //-----------------------------------------------------------------------------------------
    public function aboutus()
    {
        $cart = Cart::getCart();
        $dataprice = $cart->getContents();
        $data = ProductDao::aboutusall();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/aboutus.html.twig', ['aboutUs' => $data, 'cart' => $dataprice]);
    }
    public function forgotten()
    {
        $cart = Cart::getCart();
        $dataprice = $cart->getContents();
        $data = ProductDao::forgottenall();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/forgotten.html.twig', ['frogotten' => $data, 'cart' => $dataprice]);
    }
    public function contact()
    {
        $cart = Cart::getCart();
        $dataprice = $cart->getContents();
        $data = ProductDao::contactall();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/contact.html.twig', ['contact' => $data, 'cart' => $dataprice]);
    }
    public function faq()
    {
        $cart = Cart::getCart();
        $dataprice = $cart->getContents();
        $data = ProductDao::faqall();
        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/gyik.html.twig', ['faq' => $data, 'cart' => $dataprice]);
    }





    public function setTwigEnvironment()
    {

        $loader = new FilesystemLoader(__DIR__ . '\..\View');
        $twig = new \Twig\Environment($loader, [
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        return $twig;
    }
    //Misnyovszki gABOR // 
    public function productlistadmin()
    {
        $data = ProductDao::productlistadmin();
        $twig = (new ProductController())->setTwigEnvironment();
        $admin = User::isAdmin();
        $FelhasznaloAdatok = ProductDao::profilpageall();
        if ($admin == 1) {
            echo $twig->render('admin/products.html.twig', ['listproduct' => $data,  'FelhasznaloAdatok' => $FelhasznaloAdatok]);
        } else {
            echo $twig->render('404.html.twig');
        }
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            ProductDao::delete();
            header('Location: /adminlist');
        }
    }


    public function deleteById(int $id)
    {
        $twig = (new ProductController())->setTwigEnvironment();
        $data = ProductDao::getById($id);
        $FelhasznaloAdatok = ProductDao::profilpageall();
        if ($data) {
            $admin = User::isAdmin();
            if ($admin == 1) {
                echo $twig->render('admin/delete_cipo.html.twig', ['product' => $data,   'FelhasznaloAdatok' => $FelhasznaloAdatok]);
            } else {
                echo $twig->render('404.html.twig');
            }
        } else {
            echo $twig->render('404.html.twig');
        }
    }



    public function editById(int $id)
    {
        $twig = (new ProductController())->setTwigEnvironment();
        $data = ProductDao::getById($id);
        $allapotok = ProductDao::allapotokall();
        $markak = ProductDao::markakall();
        $FelhasznaloAdatok = ProductDao::profilpageall();
        if ($data) {
            $admin = User::isAdmin();
            if ($admin == 1) {
                echo $twig->render('admin/edit_cipo.html.twig', ['product' => $data,  'allapotok' => $allapotok, 'markak' => $markak,    'FelhasznaloAdatok' => $FelhasznaloAdatok]);
            } else {
                echo $twig->render('404.html.twig');
            }
        } else {
            echo $twig->render('404.html.twig');
        }
    }



    public function update()
    {
        if (isset($_POST['update'])) {
            ProductDao::update();
            header('Location: /adminlist');
        }
    }



    public function add()
    {
        $twig = (new ProductController())->setTwigEnvironment();
        $allapotok = ProductDao::allapotokall();
        $markak = ProductDao::markakall();

        $admin = User::isAdmin();
        $FelhasznaloAdatok = ProductDao::profilpageall();
        if ($admin == 1) {
            echo $twig->render('admin/add_new_product.html.twig', ['allapotok' => $allapotok, 'markak' => $markak,  'FelhasznaloAdatok' => $FelhasznaloAdatok]);
        } else {
            echo $twig->render('404.html.twig');
        }
    }

    public function save()
    {
        if (isset($_POST['feltoltes'])) {
            ProductDao::save();
            header('Location: /adminlist');
        }
    }



    public function adminalluserlist()
    {
        $data = ProductDao::adminalluserlist();
        $twig = (new ProductController())->setTwigEnvironment();
        $FelhasznaloAdatok = ProductDao::profilpageall();


        $admin = User::isAdmin();
        if ($admin == 1) {
            echo $twig->render('admin/alluserlist.html.twig', ['alluser' => $data,     'FelhasznaloAdatok' => $FelhasznaloAdatok]);
        } else {
            echo $twig->render('404.html.twig');
        }
    }


    public function userDelete()
    {
        if (isset($_POST['userDelete'])) {
            ProductDao::userDelete();
            header('Location: /alluserlist');
        }
    }
    public function DeleteUserById(int $id)
    {
        $twig = (new ProductController())->setTwigEnvironment();
        $data = ProductDao::UsergetById($id);
        $FelhasznaloAdatok = ProductDao::profilpageall();

        if ($data) {
            $admin = User::isAdmin();
            if ($admin == 1) {
                echo $twig->render('admin/delete_user.html.twig', ['user' => $data,  'FelhasznaloAdatok' => $FelhasznaloAdatok]);
            } else {
                echo $twig->render('404.html.twig');
            }
        } else {
            echo $twig->render('404.html.twig');
        }
    }

  



    public function orderlist()
    {
        $data = ProductDao::adminorderlist();
        $twig = (new ProductController())->setTwigEnvironment();
        $FelhasznaloAdatok = ProductDao::profilpageall();

        $admin = User::isAdmin();
        if ($admin == 1) {
            echo $twig->render('admin/order_list.html.twig', ['orders' => $data, 'FelhasznaloAdatok' => $FelhasznaloAdatok]);
        } else {
            echo $twig->render('404.html.twig');
        }
    }
    public function ordergetbyid(int $id)
    {
        $twig = (new ProductController())->setTwigEnvironment();
        $data = ProductDao::ordergetbyid($id);
        $fizetesimodok = ProductDao::fizetesimodokall();
        $FelhasznaloAdatok = ProductDao::profilpageall();


        if ($data) {
            $admin = User::isAdmin();
            if ($admin == 1) {
                echo $twig->render('admin/edit_order.html.twig', ['orders' => $data, 'fizetesimodok' => $fizetesimodok, 'FelhasznaloAdatok' => $FelhasznaloAdatok]);
            } else {
                echo $twig->render('404.html.twig');
            }
        } else {
            echo $twig->render('404.html.twig');
        }
    }

    public function orderupdate()
    {
      
        if (isset($_POST['orderupdate'])) {
            ProductDao::orderupdate();

            $id = $_POST['id'];

            $nev = $_POST['nev'];
            $rendelesallapot = $_POST['rendelesallapot'];
            $email = $_POST['email'];
            $szallitasszoveg = "";
            $szallitas = "A Rendelésed feldolgozásra került és a feladásra került a csomagszállító cégnek.";
            $torolt = "A rendelésed törlésre került";
            $kezbesítve = "A rendelésed kézbesítve lett";

            if ($rendelesallapot == "Kézbesített") {
               $allapot = $kezbesítve;
               $szallitasszoveg = "A rendelése kézbesítve lett a megadott címre";
            }
            if ($rendelesallapot == "Szállítás alatt") {
                $allapot = $szallitas;
                $szallitasido = "A RENDELÉSED FELADÁSRA KERÜLT A CSOMAGSZÁLLÍTÓ CÉGNEK, VÁRHATÓ SZÁLLÍTÁSI IDŐ 2-3 MUNKANAP";
                $szallitasszoveg = "Ha a rendelése 7 napon belül nem érkezik meg az e-mail kiküldését követően, kérjük, hogy lépjen kapcsolatba egyik kollégánkkal";
             }
             if ($rendelesallapot == "Törölt") {
                $allapot = $torolt;
                $szallitasszoveg = "A rendelése törölve lett";
             }else {
                $allapot = $torolt;
                $szallitasszoveg = "A rendelése törölve lett";
             }
         
            $varosok = ProductDao::varosok();
            $profiladat = ProductDao::profilpageall();
          

            $cart = Cart::getCart();
            $data = $cart->getContents();
            $maindata = ProductDao::mainproductsall();

            $mail = new PHPMailer();
            //email 
            $twig = $this->setTwigEnvironment();
            $ido = date('H:i:s');
            $ordercontent = $twig->render('orderchangeemail.html.twig', ['allproduct' => $maindata, 'vasarlo' => $nev, 'ido' => $ido, 'profilData' => $profiladat, 'varosok' => $varosok, 'allapot' => $allapot, 'szallitasiido' => $szallitasido, 'szallitasszoveg' => $szallitasszoveg]);
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = "587";
            $mail->Username = "boroplug.info@gmail.com";
            $mail->Password = "sdyyhxbtgemcgirf    ";
            $mail->Subject = "Rendelés Módosítás";
            $mail->setFrom('boroplug.info@gmail.com');
            $mail->isHTML(true);

            $mail->addEmbeddedImage('App/Public/template/email-template/images/order-image-2.jpg', 'mainimg', 'order-image-2.jpg');//src="cid:mainimg" alt="mainimg"
            $mail->addEmbeddedImage('App/Public/template/email-template/images/boropluglogo.jpg', 'boroplug', 'boropluglogo.jpg');
            // src="cid:boroplug" alt="boroplug"
            $mail->addEmbeddedImage('App/Public/template/email-template/images/insta.png', 'insta', 'insta.png');
            // src="cid:insta" alt="insta"
           // <img align="center" border="0" src="cid:welcome" alt="Welcome" title="image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 74%;max-width: 444px;" width="444" class="v-src-width v-src-max-width"/>
            $mail->Body = $ordercontent;
            $mail->addAddress($email);
            $mail->send();
            $mail->smtpClose();







              header('Location: /orderlist');



        }
    }

    public function diagrams()
    {


        $felhasznalo = ProductDao::felhasznalok();
        $rendelesek = ProductDao::rendelesek();
        $havibevetel = ProductDao::havibevetel();
        $fizetesimod = ProductDao::piechart();
        $lastfive = ProductDao::lastFiveOrder();
        $admin = User::isAdmin();


        $minden = ProductDao::barchart();
        $twig = (new ProductController())->setTwigEnvironment();
        $FelhasznaloAdatok = ProductDao::profilpageall();

        if ($admin == 1) {
            echo $twig->render('admin/diagrams.html.twig', [
                'felhasznalok' => $felhasznalo, 'rendelesek' => $rendelesek,
                'havibevetelek' => $havibevetel, 'utanvetel' => $fizetesimod["utanvetel"], 'bankiatutalas' => $fizetesimod["bankiatutalas"],
                'onlinefizetes' => $fizetesimod["onlinefizetes"], 'minden' => $minden, 'FelhasznaloAdatok' => $FelhasznaloAdatok , 'orders' => $lastfive ]);
        } else {
            echo $twig->render('404.html.twig');
        }
    }

    //register
    public function register()
    {

        $twig = (new ProductController())->setTwigEnvironment();
        echo $twig->render('pages/auth/register.html.twig');
    }



    public function megrendelesleadas()
    {

        $sikertelen = "";
        if (isset($_POST['megrendeles'])) {
            $result = Cart::OrderCheck();
            if ($result === true) {
                $vasarlo = User::getUser();
                $varosok = ProductDao::varosok();
                $profiladat = ProductDao::profilpageall();
                $email = $vasarlo->email;

                $cart = Cart::getCart();
                $data = $cart->getContents();
                $maindata = ProductDao::mainproductsall();

                $mail = new PHPMailer();
                //email 
                $twig = $this->setTwigEnvironment();
                $ido = date('H:i:s');
                $ordercontent = $twig->render('orderemail.html.twig', ['cart' => $data, 'allproduct' => $maindata, 'vasarlo' => $vasarlo->name, 'ido' => $ido, 'profilData' => $profiladat, 'varosok' => $varosok, 'sikertelen' => $sikertelen]);
                $mail->CharSet = "UTF-8";
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Port = "587";
                $mail->Username = "boroplug.info@gmail.com";
                $mail->Password = "sdyyhxbtgemcgirf    ";
                $mail->Subject = "Sikeres rendelés";
                $mail->setFrom('boroplug.info@gmail.com');
                $mail->isHTML(true);

                $mail->addEmbeddedImage('App/Public/template/email-template/images/order-image.jpg', 'mainimg', 'order-image.jpg');//src="cid:mainimg" alt="mainimg"
                $mail->addEmbeddedImage('App/Public/template/email-template/images/boropluglogo.jpg', 'boroplug', 'boropluglogo.jpg');
                // src="cid:boroplug" alt="boroplug"
                $mail->addEmbeddedImage('App/Public/template/email-template/images/insta.png', 'insta', 'insta.png');
                // src="cid:insta" alt="insta"
               // <img align="center" border="0" src="cid:welcome" alt="Welcome" title="image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 74%;max-width: 444px;" width="444" class="v-src-width v-src-max-width"/>
                $mail->Body = $ordercontent;
                $mail->addAddress($email);
                $mail->send();
                $mail->smtpClose();
                header('Location: /allproduct');



                echo "Sikeres megrendelés";
                $cart = new Cart();
                $cart->clear();
            } else {
               

                if (isset($_GET['sikertelen'])) {
                    $sikertelen = $_GET['sikertelen'];
                    echo $sikertelen;
                }
                header('Location: /chechkout');
                $cart = new Cart();
                $cart->clear();
               
               
            }
        }

        
    }
}
