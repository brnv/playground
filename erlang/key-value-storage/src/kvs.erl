-module (kvs).
-behaviour (gen_server).

-export ([run/0, add/2, remove/1, get/1]).

-export ([init/1, handle_call/3, handle_cast/2,
          terminate/2, handle_info/2, code_change/3]).

run() ->
    gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).

init(_Args) ->
    State = dict:new(),
    {ok, State}.

add(Key, Value) ->
    gen_server:call(?MODULE, {add, Key, Value}).
remove(Key) ->
    gen_server:call(?MODULE, {remove, Key}).
get(Key) ->
    gen_server:call(?MODULE, {get, Key}).

handle_call({add, Key, Value}, _From, State) ->
    {reply, ok, dict:append(Key, Value, State)};
handle_call({remove, Key}, _From, State) ->
    {reply, ok, dict:erase(Key, State)};
handle_call({get, Key}, _From, State) ->
    case dict:is_key(Key, State) of
        true ->
            [Value] = dict:fetch(Key, State),
            {reply, Value, State};
        false ->
            {reply, undefined, State}
    end.

handle_cast(_Message, State) ->
    {noreply, State}.

handle_info(_Message, State) ->
    {noreply, State}.

terminate(_Reason, _State) ->
    ok.

code_change(_Old, State, _Extra) ->
    {ok, State}.
