<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include '../dependencies.html' ?>
    <title>Addtruck</title>
</head>
<body>
    <?php include '../navbar.html'; ?>
    <div class="container">
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Collapsible Group Item #1
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Collapsible Group Item #2
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><h3>Immatriculation</h3></div>
                            <div class="col"><h3>Codes</h3></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="addTruckButton">Add a truck</button>
                    <button type="button" class="btn btn-primary" id="sendTrucksButton">Send trucks</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let systems=null;
        let truckFields=[];
        let addTruckButton=document.getElementById("addTruckButton");
        let sendTrucksButton=document.getElementById("sendTrucksButton");
        window.onload=function () {
            getSystems();
        }

        addTruckButton.addEventListener("click", function(){
            createTruckContainer();
            console.log(truckFields);
        })

        function sendTrucks() {
            let xhr=new XMLHttpRequest();
            xhr.withCredentials=true;
            xhr.responseType="json";
            xhr.onload=function () {
                console.log(xhr.response);
            }
            xhr.open("put", "http://127.0.0.1:8000/api/trucks", true);
            let trucks={trucks:[]};
            for (let i=0; i<truckFields.length; i++){
                let truck={
                    numberplate:truckFields[i].numberplate.value,
                    homeagency:1,
                    type:1,
                    activity:1,
                    codes:[]
                }
                for (let j=0; j<truckFields[i]["codes"].length; j++){
                    truck.codes.push({code:truckFields[i]["codes"][j].code.value ,system:truckFields[i]["codes"][j].system.options[truckFields[i]["codes"][j].system.selectedIndex].value})
                }
                trucks.trucks.push(truck);
            }
            //console.log();
            xhr.send(JSON.stringify(trucks))
        }

        sendTrucksButton.addEventListener("click", function(){
            sendTrucks();
        })

        function createTruckContainer(){
            let trucksField={numberplate:null, codes:[]};
            let container=document.createElement("div");
            container.classList.add("row");
            container.classList.add("truckcontainer");
            container.style.backgroundColor="red";

            let numberplateContainer=document.createElement("div");
            numberplateContainer.classList.add("col-2");
            numberplateContainer.style.backgroundColor="green";
            container.append(numberplateContainer);

            let numberplateField=document.createElement("input");
            numberplateField.type="text";
            numberplateField.classList.add("form-control");
            numberplateField.classList.add("numberplateField");
            trucksField.numberplate=numberplateField;
            numberplateContainer.append(numberplateField);

            let codescolumn=document.createElement("div");
            codescolumn.classList.add("col");
            codescolumn.classList.add("codescolumn");
            codescolumn.style.backgroundColor="blue";

            let truckcodes=createTruckCodes(trucksField);
            trucksField.codes.push(truckcodes[1]);
            /*codescolumn.append(truckcodes[0]);
            codescolumn.append(truckcodes[1]);*/
            codescolumn.append(truckcodes[0]);
            container.append(codescolumn);

            let card=document.getElementsByClassName("card-body")[1];
            truckFields.push(trucksField);
            card.append(container);
        }

        function createCode(truckField) {
            //let codescolumn=document.getElementsByClassName("codescolumn")[0];
            let code={system: null, code: null};
            let codescontainer=document.createElement("div");
            codescontainer.classList.add("row");
            codescontainer.classList.add("codecontainer");

            let systemColumn=document.createElement("div");
            systemColumn.classList.add("col");
            let systemsselect=createSystemSelect();
            systemColumn.append(systemsselect);
            code.system=systemsselect;
            codescontainer.append(systemColumn);

            let codeColumn=document.createElement("div");
            codeColumn.classList.add("col");

            let codeField=document.createElement("input");
            codeField.type="text";
            codeField.classList.add("form-control");
            code.code=codeField;
            codeColumn.append(codeField);
            codescontainer.append(codeColumn);
            //codescolumn.append(codescontainer);
            //truckField.code.push(code);
            return  [codescontainer, code];


        }

        function createTruckCodes(trucksField){
            let maincontainer=document.createElement("div");
            let code=null;
            maincontainer.classList.add("row");

            let codescontainer=document.createElement("div");
            codescontainer.classList.add("col");
            let newCode=createCode(trucksField);
            code=newCode[1];
            codescontainer.append(newCode[0]);
            maincontainer.append(codescontainer);

            let codebuttoncontainer=document.createElement("div");
            codebuttoncontainer.classList.add("col");
            let addcodebutton=document.createElement("button");
            addcodebutton.type="button";
            addcodebutton.classList.add("btn");
            addcodebutton.classList.add("btn-primary");
            addcodebutton.innerHTML="Add Code";
            addcodebutton.dataset.index=truckFields.length.toString();
            addcodebutton.addEventListener("click", function(){
                let newCode=createCode(trucksField);
                code=newCode[1];
                truckFields[addcodebutton.dataset.index].codes.push(code);
                codescontainer.append(newCode[0]);

            })
            codebuttoncontainer.append(addcodebutton);
            maincontainer.append(codebuttoncontainer);
            return [maincontainer, code];
        }

        function createSystemSelect(){
            let select=document.createElement("select");
            select.classList.add("form-control");
            for (let i = 0; i <5; i++) {
                let optionField=document.createElement("option");
                optionField.innerHTML=systems[i]["name"];
                optionField.value=systems[i]["id"];
                select.append(optionField);
            }
            return select;
        }


        function getSystems() {
            let xhr=new XMLHttpRequest();
            xhr.responseType="json";
            xhr.withCredentials=true;
            xhr.onload=function(){
                updateSystemsList(xhr.response);
            }
            xhr.open("get", "http://127.0.0.1:8000/api/systems", true);
            xhr.send();
        }

        function updateSystemsList(response) {
            systems=response;
            console.log(systems);
        }
    </script>
</body>
</html>
