(function() {
    let scene, camera, renderer, controls, currentModel;
    const loader = new THREE.FBXLoader();
    const textureLoader = new THREE.TextureLoader();
    
    // Configuración de rutas
    const PATH_AMARILLO = 'gatos/productos/producto1/color1/source/producto1Amarillo.fbx';
    const PATH_AZUL = 'gatos/productos/producto1/color2/source/producto1Azul.fbx';
    const FOLDER_TEXTURAS_AZUL = 'gatos/productos/producto1/color2/textures/';

    function init() {
        const container = document.getElementById('container-3d');
        if (!container) return;

        scene = new THREE.Scene();
        scene.background = new THREE.Color(0xfcfcfc);

        camera = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 1, 1000);
        camera.position.set(0, 80, 180); 

        // Iluminación
        const ambientLight = new THREE.AmbientLight(0xffffff, 1.3); 
        scene.add(ambientLight);

        const light = new THREE.DirectionalLight(0xffffff, 0.7);
        light.position.set(50, 100, 50);
        scene.add(light);

        renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer.domElement);

        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.target.set(0, 40, 0);

        createColorButtons(container);

        // Carga inicial: Amarillo
        cargarModelo(PATH_AMARILLO, false);

        animate();
    }

    function createColorButtons(container) {
        const div = document.createElement('div');
        div.style.cssText = `position: absolute; bottom: 15px; right: 15px; display: flex; gap: 10px; z-index: 10;`;
        
        div.appendChild(createCircle('#F9D71C', PATH_AMARILLO, false)); 
        div.appendChild(createCircle('#2196F3', PATH_AZUL, true));      
        
        container.appendChild(div);
    }

    function createCircle(colorHex, path, esAzul) {
        const circle = document.createElement('div');
        circle.style.cssText = `width: 25px; height: 25px; border-radius: 50%; background: ${colorHex}; cursor: pointer; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.3); transition: 0.2s;`;
        circle.onclick = () => cargarModelo(path, esAzul);
        return circle;
    }

    function cargarModelo(path, esAzul) {
        if (currentModel) {
            scene.remove(currentModel);
            currentModel.traverse(child => {
                if (child.isMesh) {
                    child.geometry.dispose();
                    if (child.material.map) child.material.map.dispose();
                    if (Array.isArray(child.material)) {
                        child.material.forEach(m => m.dispose());
                    } else {
                        child.material.dispose();
                    }
                }
            });
        }

        loader.load(path, function (object) {
            currentModel = object;
            currentModel.scale.set(4.9, 4.9, 4.9);
            
            const box = new THREE.Box3().setFromObject(currentModel);
            const center = box.getCenter(new THREE.Vector3());
            currentModel.position.sub(center);
            currentModel.position.y += 40; 

            currentModel.traverse(child => {
                if (child.isMesh) {
                    const materials = Array.isArray(child.material) ? child.material : [child.material];
                    
                    materials.forEach((m, index) => {
                        // Verificamos si la pieza tiene un mapa de textura asignado originalmente en el FBX
                        const tieneTexturaOriginal = !!m.map;

                        if (esAzul && tieneTexturaOriginal) {
                            // --- PIEZAS CON TEXTURA EN EL AZUL (Casetas, peldaños) ---
                            m.color.setHex(0xffffff); 
                            
                            let texIndex = (index % 3) + 1;
                            let texturePath = FOLDER_TEXTURAS_AZUL + 'azul' + texIndex + '.png';
                            
                            m.map = textureLoader.load(texturePath);
                            m.map.encoding = THREE.sRGBEncoding;
                            m.map.flipY = false; 
                        } 
                        else if (esAzul && !tieneTexturaOriginal) {
                            // --- PIEZAS SÓLIDAS EN EL AZUL (Postes café) ---
                            // No hacemos nada para que conserve el color café del FBX
                        }
                        else {
                            // --- MODELO AMARILLO ---
                            if (m.map) {
                                m.map.encoding = THREE.sRGBEncoding;
                            }
                        }
                        m.needsUpdate = true;
                    });
                }
            });

            scene.add(currentModel);
        });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls) controls.update();
        renderer.render(scene, camera);
    }

    init();
})();