<?php
session_start();
include "./classes/gesture.class.php";
include "./classes/user.class.php";

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$user = new User();
$gesture = new Gesture();
$user_id = $_SESSION['user_id'];

$thumbGestures = $gesture->thumbGestures($user_id);
$indexGestures = $gesture->indexGestures($user_id);
$middleGestures = $gesture->middleGestures($user_id);
$ringGestures = $gesture->ringGestures($user_id);
$pinkyGestures = $gesture->pinkyGestures($user_id);
$specialGestures = $gesture->specialGestures($user_id);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["submit"])) {
        $gesture->user_id = $_POST['user_id'];
        $gesture->gesture_id = $_POST['gesture_id'];
        $gesture->custom_value = $_POST['custom_value'];
        $gesture->updateGestureValue();
        header("Location: presets.php");
        exit();
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/images/movewave_logo.png" type="image/x-icon">
    <title>Move Wave Presets</title>
    <?php include_once "./inlcude/header.php"; ?>
</head>

<body >
    
    <main class="w-100 h-100 d-flex justify-content-center align-items-center p-5 font-roboto">
        <!-- Gesture Card Container -->
        <div class="d-flex flex-column w-100 ">

        <div class="dropdown align-self-start menu w-100">
            <button class="p-1 px-2 rounded-1 bg-body-tertiary border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fi fi-rr-bars-staggered d-block mt-1"></i>
            </button>
            <ul class="dropdown-menu p-0">
                <li class="bg-purple" ><a class="dropdown-item text-white" style="background-color:#671276 !important ;" href=""><?php echo $_SESSION['username'] ?></a</li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>

            <div class="top-part d-flex justify-content-evenly w-100 ">
                <!-- Thumb Gesture Card -->
                <div class="gesture-card rounded-2 shadow border d-flex flex-column align-items-center justify-content-between p-5">
                    <img src="./assets/images/movewave_logo.png" height="100px" width="90px" alt="">
                    <span class="text-center fs-4 fw-bold">Thumb Gestures</span>
                    <?php
                    if ($thumbGestures && is_array($thumbGestures)):
                        foreach ($thumbGestures as $tg):
                            $modalId = "gestureModal" . $tg['gesture_id']; // Unique modal ID
                    ?>
                            <div class="w-100 d-flex flex-column justify-content-between align-items-center">
                                <span class="d-flex align-items-center">
                                    <?= htmlspecialchars($tg['gesture_name']) ?>
                                    <button class="border bg-transparent rounded-1 px-2 ms-4" type="button" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                        <i class="fi fi-ss-menu-dots d-block mt-1"></i>
                                    </button>
                                </span>

                                <!-- Gesture Modal -->
                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="w-100 d-flex justify-content-between align-items-center">
                                                <span class="fs-5">Edit Gesture</span>
                                                <button class="border p-1 px-2" style="border-radius: 50%;" type="button" data-bs-dismiss="modal">
                                                    <i class="fi fi-rr-cross-small d-block mt-1"></i>
                                                </button>
                                            </div>
                                            <img class="rounded-3 mt-3" src="<?php echo "./gesture_images/" . htmlspecialchars($tg['gesture_image']) ?>" style="height: 400px; width: 100%;" alt="Gesture Image">

                                            <!-- Customization Form -->
                                            <form class="update-gesture-form" action="presets.php" method="POST">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                                <input type="hidden" name="gesture_id" value="<?= $tg['gesture_id'] ?>">
                                                <input class="border form-control rounded-1 p-2 mt-2" type="text" name="custom_value" value="<?= htmlspecialchars($tg['gesture_value']) ?>">
                                                <button class="bg-purple border-0 text-white rounded-2 px-3 p-2 mt-3 w-100" type="submit" name="submit">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Index Gesture Card -->
                <div class="gesture-card rounded-2 shadow border d-flex flex-column align-items-center  p-5">
                    <img src="./assets/images/movewave_logo.png" height="100px" width="90px" alt="">
                    <span class="text-center fs-4 fw-bold mt-2">Index Gestures</span>
                    <?php
                    if ($indexGestures && is_array($indexGestures)):
                        foreach ($indexGestures as $ig):
                            $modalId = "gestureModal" . $ig['gesture_id']; // Unique modal ID
                    ?>
                            <div class="w-100 d-flex flex-column justify-content-between align-items-center my-2">
                                <span class="d-flex align-items-center">
                                    <?= htmlspecialchars($ig['gesture_name']) ?>
                                    <button class="border bg-transparent rounded-1 px-2 ms-4" type="button" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                        <i class="fi fi-ss-menu-dots d-block mt-1"></i>
                                    </button>
                                </span>

                                <!-- Gesture Modal -->
                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="w-100 d-flex justify-content-between align-items-center">
                                                <span class="fs-5">Edit Gesture</span>
                                                <button class="border p-1 px-2" style="border-radius: 50%;" type="button" data-bs-dismiss="modal">
                                                    <i class="fi fi-rr-cross-small d-block mt-1"></i>
                                                </button>
                                            </div>
                                            <img class="rounded-3 mt-3" src="<?php echo "./gesture_images/" . htmlspecialchars($ig['gesture_image']) ?>" style="height: 400px; width: 100%;" alt="Gesture Image">

                                            <!-- Customization Form -->
                                            <form class="update-gesture-form" action="presets.php" method="POST">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                                <input type="hidden" name="gesture_id" value="<?= $ig['gesture_id'] ?>">
                                                <input class="border form-control rounded-1 p-2 mt-2" type="text" name="custom_value" value="<?= htmlspecialchars($ig['gesture_value']) ?>">
                                                <button class="bg-purple border-0 text-white rounded-2 px-3 p-2 mt-3 w-100" type="submit" name="submit">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Middle Gestures Card -->
                <div class="gesture-card rounded-2 shadow border d-flex flex-column align-items-center  p-5">
                    <img src="./assets/images/movewave_logo.png" height="100px" width="90px" alt="">
                    <span class="text-center fs-4 fw-bold mt-2">Middle Gestures</span>
                    <?php
                    if ($middleGestures && is_array($middleGestures)):
                        foreach ($middleGestures as $mg):
                            $modalId = "gestureModal" . $mg['gesture_id']; // Unique modal ID
                    ?>
                            <div class="w-100 d-flex flex-column justify-content-between align-items-center my-2">
                                <span class="d-flex align-items-center">
                                    <?= htmlspecialchars($mg['gesture_name']) ?>
                                    <button class="border bg-transparent rounded-1 px-2 ms-4" type="button" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                        <i class="fi fi-ss-menu-dots d-block mt-1"></i>
                                    </button>
                                </span>

                                <!-- Gesture Modal -->
                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="w-100 d-flex justify-content-between align-items-center">
                                                <span class="fs-5">Edit Gesture</span>
                                                <button class="border p-1 px-2" style="border-radius: 50%;" type="button" data-bs-dismiss="modal">
                                                    <i class="fi fi-rr-cross-small d-block mt-1"></i>
                                                </button>
                                            </div>
                                            <img class="rounded-3 mt-3" src="<?php echo "./gesture_images/" . htmlspecialchars($mg['gesture_image']) ?>" style="height: 400px; width: 100%;" alt="Gesture Image">

                                            <!-- Customization Form -->
                                            <form class="update-gesture-form" action="presets.php" method="POST">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                                <input type="hidden" name="gesture_id" value="<?= $mg['gesture_id'] ?>">
                                                <input class="border form-control rounded-1 p-2 mt-2" type="text" name="custom_value" value="<?= htmlspecialchars($mg['gesture_value']) ?>">
                                                <button class="bg-purple border-0 text-white rounded-2 px-3 p-2 mt-3 w-100" type="submit" name="submit">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>

            <div class="bottom-part d-flex justify-content-evenly w-100 mt-5">
                <!-- Ring Gestures Card -->
                <div class="gesture-card rounded-2 shadow border d-flex flex-column align-items-center p-5">
                    <img src="./assets/images/movewave_logo.png" height="100px" width="90px" alt="">
                    <span class="text-center fs-4 fw-bold mt-2">Ring Gestures</span>
                    <?php
                    if ($ringGestures && is_array($ringGestures)):
                        foreach ($ringGestures as $rg):
                            $modalId = "gestureModal" . $rg['gesture_id']; // Unique modal ID
                    ?>
                            <div class="w-100 d-flex flex-column justify-content-between align-items-center my-2">
                                <span class="d-flex align-items-center">
                                    <?= htmlspecialchars($rg['gesture_name']) ?>
                                    <button class="border bg-transparent rounded-1 px-2 ms-4" type="button" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                        <i class="fi fi-ss-menu-dots d-block mt-1"></i>
                                    </button>
                                </span>

                                <!-- Gesture Modal -->
                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="w-100 d-flex justify-content-between align-items-center">
                                                <span class="fs-5">Edit Gesture</span>
                                                <button class="border p-1 px-2" style="border-radius: 50%;" type="button" data-bs-dismiss="modal">
                                                    <i class="fi fi-rr-cross-small d-block mt-1"></i>
                                                </button>
                                            </div>
                                            <img class="rounded-3 mt-3" src="<?php echo "./gesture_images/" . htmlspecialchars($rg['gesture_image']) ?>" style="height: 400px; width: 100%;" alt="Gesture Image">

                                            <!-- Customization Form -->
                                            <form class="update-gesture-form" action="presets.php" method="POST">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                                <input type="hidden" name="gesture_id" value="<?= $rg['gesture_id'] ?>">
                                                <input class="border form-control rounded-1 p-2 mt-2" type="text" name="custom_value" value="<?= htmlspecialchars($rg['gesture_value']) ?>">
                                                <button class="bg-purple border-0 text-white rounded-2 px-3 p-2 mt-3 w-100" type="submit" name="submit">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Pingky Gestures Card -->
                <div class="gesture-card rounded-2 shadow border d-flex flex-column align-items-center p-5">
                    <img src="./assets/images/movewave_logo.png" height="100px" width="90px" alt="">
                    <span class="text-center fs-4 fw-bold mt-2">Pinky Gestures</span>
                    <?php
                    if ($pinkyGestures && is_array($pinkyGestures)):
                        foreach ($pinkyGestures as $pg):
                            $modalId = "gestureModal" . $pg['gesture_id']; // Unique modal ID
                    ?>
                            <div class="w-100 d-flex flex-column justify-content-between align-items-center mt-3">
                                <span class="d-flex align-items-center">
                                    <?= htmlspecialchars($pg['gesture_name']) ?>
                                    <button class="border bg-transparent rounded-1 px-2 ms-4" type="button" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                        <i class="fi fi-ss-menu-dots d-block mt-1"></i>
                                    </button>
                                </span>

                                <!-- Gesture Modal -->
                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="w-100 d-flex justify-content-between align-items-center">
                                                <span class="fs-5">Edit Gesture</span>
                                                <button class="border p-1 px-2" style="border-radius: 50%;" type="button" data-bs-dismiss="modal">
                                                    <i class="fi fi-rr-cross-small d-block mt-1"></i>
                                                </button>
                                            </div>
                                            <img class="rounded-3 mt-3" src="<?php echo "./gesture_images/" . htmlspecialchars($pg['gesture_image']) ?>" style="height: 400px; width: 100%;" alt="Gesture Image">

                                            <!-- Customization Form -->
                                            <form class="update-gesture-form" action="presets.php" method="POST">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                                <input type="hidden" name="gesture_id" value="<?= $pg['gesture_id'] ?>">
                                                <input class="border form-control rounded-1 p-2 mt-2" type="text" name="custom_value" value="<?= htmlspecialchars($pg['gesture_value']) ?>">
                                                <button class="bg-purple border-0 text-white rounded-2 px-3 p-2 mt-3 w-100" type="submit" name="submit">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Special Gestures Card -->
                <div class="gesture-card rounded-2 shadow border d-flex flex-column align-items-center justify-content-between p-5">
                    <img src="./assets/images/movewave_logo.png" height="100px" width="90px" alt="">
                    <span class="text-center fs-4 fw-bold">Special Gestures</span>
                    <?php
                    if ($specialGestures && is_array($specialGestures)):
                        foreach ($specialGestures as $sg):
                            $modalId = "gestureModal" . $sg['gesture_id']; // Unique modal ID
                    ?>
                            <div class="w-100 d-flex flex-column justify-content-between align-items-center">
                                <span class="d-flex align-items-center">
                                    <?= htmlspecialchars($sg['gesture_name']) ?>
                                    <button class="border bg-transparent rounded-1 px-2 ms-4" type="button" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                        <i class="fi fi-ss-menu-dots d-block mt-1"></i>
                                    </button>
                                </span>

                                <!-- Gesture Modal -->
                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <div class="w-100 d-flex justify-content-between align-items-center">
                                                <span class="fs-5">Edit Gesture</span>
                                                <button class="border p-1 px-2" style="border-radius: 50%;" type="button" data-bs-dismiss="modal">
                                                    <i class="fi fi-rr-cross-small d-block mt-1"></i>
                                                </button>
                                            </div>
                                            <img class="rounded-3 mt-3" src="<?php echo "./gesture_images/" . htmlspecialchars($sg['gesture_image']) ?>" style="height: 400px; width: 100%;" alt="Gesture Image">

                                            <!-- Customization Form -->
                                            <form class="update-gesture-form" action="presets.php" method="POST">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                                <input type="hidden" name="gesture_id" value="<?= $sg['gesture_id'] ?>">
                                                <input class="border form-control rounded-1 p-2 mt-2" type="text" name="custom_value" value="<?= htmlspecialchars($sg['gesture_value']) ?>">
                                                <button class="bg-purple border-0 text-white rounded-2 px-3 p-2 mt-3 w-100" type="submit" name="submit">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </main>
    <?php include_once "./inlcude/footer.php"; ?>

</body>

</html>