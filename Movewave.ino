#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <HTTPClient.h>
#include <WiFiManager.h> // Include the WiFiManager library
#include <UniversalTelegramBot.h>

// Server URL
String serverName = "https://movewave.online/MoveWave_V2/fetch_gesture.php";

// Telegram Bot credentials
String telegramBotToken = "8127084337:AAH_1xCbf8U3DCUkfP8HBk3wXwgFAabuFw0"; // Replace with your Telegram bot token
String telegramChatId = "6755870128"; // Replace with your Telegram chat ID

WiFiClientSecure client;
UniversalTelegramBot bot(telegramBotToken, client);

// Flex sensor pins
const int flexPinThumb = 36;
const int flexPinIndex = 35;
const int flexPinMiddle = 34;
const int flexPinRing = 33;
const int flexPinPinky = 32;

// Gesture variables
String lastGestureValue = "";

// Send gesture data to the server
String fetchGestureValue(String gesture_name) {
  String gestureValue = "";
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    String postData = "gesture_name=" + gesture_name;

    http.begin(serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int httpResponseCode = http.POST(postData);
    if (httpResponseCode > 0) {
      gestureValue = http.getString(); // Get the server response (gesture_value)
      Serial.println("Gesture Value from server: " + gestureValue);
    } else {
      Serial.println("Error sending POST request");
    }
    http.end();
  } else {
    Serial.println("WiFi not connected");
  }
  return gestureValue;
}

// Detect and process gestures
String detectGesture() {
  int thumb_value = analogRead(flexPinThumb);
  int index_value = analogRead(flexPinIndex);
  int middle_value = analogRead(flexPinMiddle);
  int ring_value = analogRead(flexPinRing);
  int pinky_value = analogRead(flexPinPinky);

  String gesture_name = "";

  // Gesture detection logic (unchanged)
  if (thumb_value > 250 && thumb_value < 650) {
    if (thumb_value > 250 && thumb_value < 650 && index_value > 250 && index_value < 650 && 
        middle_value > 250 && middle_value < 650 && ring_value > 250 && ring_value < 650 && 
        pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Communication 20";  // All fingers
    } else if (middle_value > 250 && middle_value < 650 && ring_value > 250 && ring_value < 650) {
      gesture_name = "Communication 18";  // Thumb, Middle & Ring
    } else if (index_value > 250 && index_value < 650) {
      gesture_name = "Communication 2";  // Thumb & Index
    } else if (middle_value > 250 && middle_value < 650) {
      gesture_name = "Communication 3";  // Thumb & Middle
    } else if (ring_value > 250 && ring_value < 650) {
      gesture_name = "Communication 4";  // Thumb & Ring
    } else if (pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Communication 5";  // Thumb & Pinky
    } else {
      gesture_name = "Communication 1";  // Thumb only
    }
  } else if (index_value > 250 && index_value < 650) {
    if (middle_value > 250 && middle_value < 650 && ring_value > 250 && ring_value < 650 && 
        pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Communication 16";  // Index, Middle, Ring & Pinky
    } else if (middle_value > 250 && middle_value < 650 && ring_value > 250 && ring_value < 650) {
      gesture_name = "Communication 17";  // Index, Middle & Ring
    } else if (middle_value > 250 && middle_value < 650) {
      gesture_name = "Communication 7";  // Index & Middle
    } else if (ring_value > 250 && ring_value < 650) {
      gesture_name = "Communication 8";  // Index & Ring
    } else if (pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Communication 9";  // Index & Pinky
    } else {
      gesture_name = "Communication 6";  // Index only
    }
  } else if (middle_value > 250 && middle_value < 650) {
    if (ring_value > 250 && ring_value < 650 && pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Communication 19";  // Middle, Ring & Pinky
    } else if (ring_value > 250 && ring_value < 650) {
      gesture_name = "Communication 11";  // Middle & Ring
    } else if (pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Communication 12";  // Middle & Pinky
    } else {
      gesture_name = "Communication 10";  // Middle only
    }
  } else if (ring_value > 250 && ring_value < 650) {
    if (pinky_value > 250 && pinky_value < 650) {
      gesture_name = "Communication 14";  // Ring & Pinky
    } else {
      gesture_name = "Communication 13";  // Ring only
    }
  } else if (pinky_value > 250 && pinky_value < 650) {
    gesture_name = "Communication 15";  // Pinky only
  }

  return gesture_name;
}

// Setup function
void setup() {
  Serial.begin(115200);

  // Initialize WiFiManager
  WiFiManager wifiManager;
  wifiManager.autoConnect("ESP32-Glove"); // AutoConnect with fallback web portal

  Serial.println("Connected to WiFi!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // Initialize Telegram Bot
  client.setCACert(TELEGRAM_CERTIFICATE_ROOT); // Secure connection for Telegram
  bot.sendMessage(telegramChatId, "ESP32 Connected", "");

  // Pin modes
  pinMode(flexPinThumb, INPUT);
  pinMode(flexPinIndex, INPUT);
  pinMode(flexPinMiddle, INPUT);
  pinMode(flexPinRing, INPUT);
  pinMode(flexPinPinky, INPUT);
}

// Loop function
void loop() {
  String detectedGestureName = detectGesture();

  if (detectedGestureName != "") {
    String gestureValue = fetchGestureValue(detectedGestureName);

    if (gestureValue != "" && gestureValue != lastGestureValue) {
      lastGestureValue = gestureValue;  

      // Display and send only the gesture value
      Serial.println("Detected Gesture: " + gestureValue);
      bot.sendMessage(telegramChatId, gestureValue, "");
    }
  }

  delay(3500); // Adjust delay as needed
}
