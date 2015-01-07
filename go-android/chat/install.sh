./clean.sh

mkdir -p jni/armeabi
CGO_ENABLED=1 GOOS=android GOARCH=arm GOARM=7 \
	go build -ldflags="-shared" -o jni/armeabi/libchat.so .
ndk-build NDK_DEBUG=1
ant debug

adb install -r bin/nativeactivity-debug.apk

adb shell am start -a android.intent.action.MAIN \
	-n com.example.chat/android.app.NativeActivity
