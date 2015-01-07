package main

import (
	"fmt"
	"net/http"

	"code.google.com/p/go.net/websocket"

	"golang.org/x/mobile/app"
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
	app.Run(app.Callbacks{
		Start: start,
	})
}

func handler(w http.ResponseWriter, r *http.Request) {
	w.Write([]byte(indexHtml))
}

func start() {
	go messenger()

	go func() {
		http.HandleFunc("/", handler)
		http.Handle("/ws/chat", websocket.Handler(chatServer))
		http.ListenAndServe(":12345", nil)
	}()
}

const indexHtml = `
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <script type="text/javascript" charset="utf-8">
    var ws = new WebSocket("ws://192.168.1.103:12345/ws/chat")

    ws.onmessage = function(message) {
        var p = document.createElement("p");
        p.innerHTML = message.data;
        document.getElementById("chat").appendChild(p);
    }

    function send() {
        var message = document.getElementById("message").value
        ws.send(message)
    }

    </script>
    <p>
        <div id="chat">
            <p>Hello</p>
        </div>
    </p>
    <p>
        <input type="text" id="message" />
        <input type="button" onclick="send()" value="send"/>
    </p>
</body>
</html>
`
