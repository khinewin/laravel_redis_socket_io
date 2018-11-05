@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body" style="height: 300px">
                    <ul class="list-group" v-for="msg in messages">
                        <div class="row">
                            <div v-if="msg.user.id==user.id">
                            <li class="list-group-item float-right" >@{{ msg.message }}</li>
                            </div>
                            <div v-else>
                            <li class="list-group-item float-left" >@{{ msg.message }}</li>
                            </div>
                        </div>
                    </ul>
                </div>
                <div class="card-footer">
                    <form>
                        <div class="form-group">
                            <div class="row">
                            <div class="col-10">
                            <input v-model="message" type="text" class="form-control">
                            </div>
                            <div class="col-2">
                                <button @click.prevent="sendMessage()" type="submit" class="btn btn-primary">Send</button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        const app=new Vue({
            el : "#app",
            data: {
                user: {!! Auth::check() ? Auth::User() : null !!},
                message: '',
                messages: {},
            },

            created(){
                console.log("Vue is working on template");
                this.getAllMessage();
            },
            methods: {
                getAllMessage(){
                    axios.get('/message').then(doc=>{
                        this.messages=doc.data.messages;
                        //console.log(doc)
                    }).catch(err=>{
                        console.log(err)
                    });
                },
                sendMessage(){
                    axios.post('/send',{
                        message:this.message
                    }).then(doc=>{
                        this.messages.push(doc.data.messages)
                        //console.log(doc)
                        this.message=''
                    }).catch(err=>{
                        console.log(err)
                    });
                }
            },
            sockets: {
                message(data){
                    const msgs=JSON.parse(data);
                    this.messages.push(msgs);
                }
            }
        })
    </script>
    @stop
