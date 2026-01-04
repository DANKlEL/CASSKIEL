(function() {
    let scene3, camera3, renderer3, controls3, currentModel3;
    const loader3 = new THREE.FBXLoader();
    
    // Cambia esto en producto3.js
    const PATH_MODELO = '/AccesoriosMaya/gatos/productos/producto3/source/producto3_v2.fbx';

    function init() {
        const container = document.getElementById('container-3d-p3');
        if (!container) return;

        scene3 = new THREE.Scene();
        scene3.background = new THREE.Color(0xfcfcfc);

        camera3 = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 1, 1000);
        camera3.position.set(120, 150, -20); 

        const ambientLight = new THREE.AmbientLight(0xffffff, 1.5); 
        scene3.add(ambientLight);

        const light = new THREE.DirectionalLight(0xffffff, 0.8);
        light.position.set(50, 150, 50);
        scene3.add(light);

        renderer3 = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer3.setSize(container.clientWidth, container.clientHeight);
        renderer3.setPixelRatio(window.devicePixelRatio);
        renderer3.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer3.domElement);

        controls3 = new THREE.OrbitControls(camera3, renderer3.domElement);
        controls3.enableDamping = true;

        cargarModelo(PATH_MODELO);
        animate();
    }

    function cargarModelo(path) {
        loader3.load(path, function (object) {
            currentModel3 = object;
            
            // Si no lo ves al cargar, intenta cambiar el 1 por 0.1 o por 50
            currentModel3.scale.set(5, 5, 5); 
            
            const box = new THREE.Box3().setFromObject(currentModel3);
            const center = box.getCenter(new THREE.Vector3());
            currentModel3.position.sub(center);
            currentModel3.position.y += 20; 

            scene3.add(currentModel3);
            console.log("Producto 3 cargado correctamente v7.5");
        }, undefined, function(error) {
            console.error("Error al cargar FBX v7.5:", error);
        });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls3) controls3.update();
        renderer3.render(scene3, camera3);
    }

    init();
})();