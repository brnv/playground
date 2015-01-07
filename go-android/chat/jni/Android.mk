LOCAL_PATH := $(call my-dir)
include $(CLEAR_VARS)

LOCAL_MODULE    := chat
LOCAL_SRC_FILES := $(TARGET_ARCH_ABI)/libchat.so

include $(PREBUILT_SHARED_LIBRARY)
