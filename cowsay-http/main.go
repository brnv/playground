package main

import (
	"fmt"
	"log"
	"net/http"
	"os/exec"

	"github.com/gocraft/web"
)

func main() {
	type Context struct{}
	router := web.New(Context{}).
		Get("/", handleRoot)

	err := http.ListenAndServe(":80", router)
	if err != nil {
		log.Fatal("[error]", err)
	}
}

func handleRoot(w web.ResponseWriter, r *web.Request) {
	cmd := exec.Command("cowsay", fmt.Sprintf("Privet, %s!", r.RemoteAddr))
	answer, err := cmd.Output()
	if err != nil {
		log.Fatal("[error]", err)
	}
	fmt.Fprint(w, string(answer))
}
