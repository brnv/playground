package main

import (
	"code.google.com/p/go.net/websocket"
	"fmt"
	"net/http"
)

var (
	clientInChan         = make(chan *websocket.Conn)
	clientOutChan        = make(chan *websocket.Conn)
	broadcastMessageChan = make(chan []byte)
)

func messenger() {
	clients := make(map[*websocket.Conn]bool)
	for {
		select {
		case client := <-clientOutChan:
			fmt.Printf("[log] client leaved %s\n", client.RemoteAddr())
			clients[client] = false
		case client := <-clientInChan:
			fmt.Printf("[log] client arrived %s\n", client.RemoteAddr())
			clients[client] = true
		case message := <-broadcastMessageChan:
			fmt.Printf("[log] message: %s\n", message)
			for client, alive := range clients {
				if alive {
					client.Write(message)
				}
			}
		}
	}
}

func chatServer(ws *websocket.Conn) {
	clientInChan <- ws
	for {
		message := make([]byte, 1024)
		_, err := ws.Read(message)
		if err != nil {
			break
		}
		broadcastMessageChan <- message
	}
	clientOutChan <- ws
}

func main() {
	go messenger()

	http.Handle("/", http.FileServer(http.Dir(".")))
	http.Handle("/ws/chat", websocket.Handler(chatServer))
	err := http.ListenAndServe(":12345", nil)
	if err != nil {
		panic("ListenAndServe: " + err.Error())
	}
}
