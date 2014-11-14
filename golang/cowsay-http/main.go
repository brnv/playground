package main

import (
	"fmt"
	"log"
	"net/http"
	"os/exec"

	"github.com/brnv/web"
)

func main() {
	type Context struct{}
	router := web.New(Context{}).
		Get("/:num", handleRoot)

	err := http.ListenAndServe(":8011", router)
	if err != nil {
		log.Fatal("[error]", err)
	}
}

func handleRoot(w web.ResponseWriter, r *web.Request) {
	numbers := exec.Command("curl", "http://number.s/"+r.PathParams["num"])
	output, _ := numbers.Output()
	cmd := exec.Command("cowsay", fmt.Sprintf("%s", output))
	answer, err := cmd.Output()
	if err != nil {
		log.Fatal("[error]", err)
	}
	fmt.Fprint(w, string(answer))
}
