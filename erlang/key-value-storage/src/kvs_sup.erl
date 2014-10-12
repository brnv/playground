-module (kvs_sup).
-behaviour (supervisor).

-export ([start_link/0, init/1]).

start_link() ->
    supervisor:start_link(kvs_sup, []).

init(_Args) ->
    {ok, {
       {one_for_one, 1, 60},
       [{kvs, {kvs, run, []},
        permanent, brutal_kill, worker, [kvs]}]
      }}.
