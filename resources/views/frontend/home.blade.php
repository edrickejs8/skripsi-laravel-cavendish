<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cavendish! - Beranda</title>
    <link rel="stylesheet" href="{{ asset('frontend/home.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('frontend/pisang-removebg-preview.png') }}" alt="Logo">
        </div>
        <nav>
            <a href="{{ route('resep') }}">Resep</a>
            <a href="{{ route('home') }}" class="active">Beranda</a>
            <a href="{{ route('profil') }}">Profil</a>
        </nav>
    </header>

    <div class="container">
        <div class="camera-box">
            <video autoplay playsinline></video>
            <div class="popup" id="popup">Matang</div>
            <button class="btn3" id="captureBtn">Capture</button>
            <div class="after-buttons" id="afterButtons">
                <button class="btn4" id="lihatResepBtn">Resep</button>
                <button class="btn5" id="lihatPenyimpananBtn">Cara Penyimpanan</button>
            </div>
        </div>
    </div>

    <script>
        console.log("📄 Script berhasil dimuat");

        const video = document.querySelector("video");
        const popup = document.getElementById("popup");
        const captureBtn = document.getElementById("captureBtn");
        const afterButtons = document.getElementById("afterButtons");

        function tampilkanModal(deskripsi) {
            document.getElementById("penyimpananDeskripsi").innerText = deskripsi;
            document.getElementById("penyimpananModal").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function tutupModal() {
            document.getElementById("penyimpananModal").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        async function startCamera () {
            try {
                const stream = await navigator.mediaDevices.getUserMedia ({ video: true });
                video.srcObject = stream;
            } catch (err) {
                console.error("Gagal mengakses kamera:", err);
                alert("Tidak bisa mengakses kamera. Coba cek izin di browser kamu.");
            }
        }

        captureBtn.addEventListener("click", async () => {
            const canvas = document.createElement("canvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);

            const base64Image = canvas.toDataURL("image/jpeg");

            try {
        const response = await fetch("/riwayat-captures", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ gambar: base64Image })
        });

        const data = await response.json();

        if (data.success) {
            const tingkatKematangan = data.data.tingkat_kematangan;
            popup.innerText = tingkatKematangan;
            popup.style.display = "block";
            captureBtn.style.display = "none";
            afterButtons.style.display = "flex";

            document.getElementById("lihatResepBtn").setAttribute("data-tingkat", tingkatKematangan);
            document.getElementById("lihatResepBtn").style.display = "block";

            console.log("✅ Prediksi berhasil:", tingkatKematangan);
        } else {
            alert("Gagal: " + (data.error || "Terjadi kesalahan saat memproses gambar"));
        }
    } catch (error) {
        console.error("❌ Error:", error);
        alert("Terjadi kesalahan saat mengirim gambar.");
    }
});

        //      try {
        //         const imageBlob = await fetch(canvas.toDataURL('image/jpeg')).then(res => res.blob());
        //         const formData = new FormData();
        //         formData.append("image", imageBlob, "capture.jpg");

        //         const response = await fetch("{{ url('/api/deteksi-kematangan') }}", {
        //             method: "POST",
        //             body: formData
        //         });

        //         const result = await response.json();

        //         if (!response.ok) {
        //             throw new Error(result.message || "Gagal mendeteksi tingkat kematangan");
        //         }

        //         const tingkatKematangan = result.prediction;
        //         const confidence = result.confidence;

        //         popup.innerText = tingkatKematangan;
        //         popup.style.display = "block";
        //         captureBtn.style.display = "none";
        //         afterButtons.style.display = "flex";

        //         console.log("Prediksi:", tingkatKematangan, "| Confidence:", confidence);
        //     } catch (error) {
        //         console.error("Error:", error);
        //         alert("Terjadi kesalahan saat proses: ", error.message);
        //     }
        // });

        document.getElementById("lihatResepBtn").addEventListener("click", function () {
            const tingkatKematangan = popup.innerText.trim(); // ini guna ngambil dari popup hasil scan
            if (tingkatKematangan) {
                window.location.href = `{{ url('/resep') }}?filter=${tingkatKematangan}`;
            } else {
                alert("Tingkat kematangan belum terdeteksi.");
            }
        });

        document.getElementById("lihatPenyimpananBtn").addEventListener("click", function () {
            const tingkatKematangan = popup.innerText.trim();
            if (!tingkatKematangan) {
                alert("Tingkat kematangan belum terdeteksi.");
                return;
            }

            window.location.href = `/penyimpanan/${tingkatKematangan}`;
        });

        startCamera();
    </script>

    <div id="penyimpananModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; border-radius:10px; padding:20px; box-shadow:0 0 10px rgba(0, 0, 0, 0.3); z-index:1000; max-width:400px;">
        <h3>Cara Penyimpanan</h3>
        <p id="penyimpananDeskripsi">Loading...</p>
        <button onclick="tutupModal()" style="margin-top: 10px; background:#FFC62E; border: none; padding:10px 20px; border-radius:6px; font-weight:bold;">Tutup</button>
    </div>
    <div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999;" onclick="tutupModal()"></div>

</body>
</html>