<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quizzes Uni – Mockup Navegable</title>
  <style>
    :root{
      --bg:#0f172a; /* slate-900 */
      --card:#111827ee; /* gray-900 */
      --ink:#e5e7eb; /* gray-200 */
      --accent:#22d3ee; /* cyan-400 */
      --accent-2:#a78bfa; /* violet-400 */
      --ok:#34d399; /* green-400 */
      --warn:#f59e0b; /* amber-500 */
      --muted:#94a3b8; /* slate-400 */
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, "Helvetica Neue", Arial;
      background: radial-gradient(1200px 800px at 20% 10%, #1f2937 0, #0b1222 60%, #090f1d 100%), var(--bg);
      color:var(--ink); display:flex; align-items:center; justify-content:center; padding:24px;
    }
    .app{width:100%; max-width: 880px;}
    .card{background:linear-gradient(180deg,#121826f2,#0b0f1ac0); border:1px solid #2a3550; box-shadow: 0 20px 60px #0006; border-radius:24px; padding:26px;}
    h1,h2{margin:0 0 12px}
    h1{font-size: clamp(28px, 4vw, 40px); letter-spacing:.3px}
    p{margin:8px 0 0; color:var(--muted)}

    .btn{appearance:none; border:1px solid #334155; background:#0b1222; color:var(--ink); padding:14px 18px; border-radius:14px; cursor:pointer; font-weight:600; transition:.18s ease;}
    .btn:hover{transform:translateY(-1px); border-color:#475569}
    .btn.primary{background:linear-gradient(90deg, var(--accent), var(--accent-2)); color:#0a0a0a; border:none}

    .row{display:flex; gap:12px; flex-wrap:wrap}
    .grid{display:grid; gap:12px}
    .menu{grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-top:18px}
    .chip{display:inline-block; padding:6px 10px; border-radius:999px; background:#0d1427; border:1px solid #26304b; color:var(--muted); font-size:12px}

    .screen{display:none}
    .screen.active{display:block}

    .question{font-size: clamp(18px, 2.4vw, 22px); margin:10px 0 14px}
    .options{display:grid; gap:10px; margin-top:10px}
    .option{padding:14px 16px; border-radius:14px; border:1px solid #25304b; background:#0b1222; cursor:pointer; transition:.15s ease}
    .option:hover{border-color:#3b4d74; transform: translateY(-1px)}

    .topbar{display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:10px}
    .progress{height:10px; background:#0c1425; border-radius:999px; border:1px solid #1f2a44; overflow:hidden}
    .progress > i{display:block; height:100%; background:linear-gradient(90deg,var(--accent),var(--accent-2)); width:0%}

    .muted{color:var(--muted)}
    .center{display:flex; flex-direction:column; align-items:center; text-align:center; gap:14px}

    .imgbox{border:1px dashed #334155; border-radius:16px; padding:12px; text-align:center; color:#9aa7bd; background:#0c1222}
  </style>
</head>
<body>
  <div class="app">
    <div class="card">

      <!-- INTRO -->
      <section id="INTRO" class="screen active center">
        <span class="chip">Demo navegable</span>
        <h1>NOOOOOOOOOO 🎉</h1>
        <p>Reta tu cultura y ríe con quizzes rápidos. No necesitas internet para este demo HTML.</p>
        <div class="row">
          <button class="btn primary" onclick="go('HOME_Menu')">Comenzar</button>
        </div>
      </section>

      <!-- MENU -->
      <section id="HOME_Menu" class="screen">
        <div class="topbar">
          <h2>Elige tu Quiz</h2>
          <button class="btn" onclick="go('INTRO')">← Intro</button>
        </div>
        <div class="grid menu">
          <button class="btn option" onclick="startQuiz('uni')">🏫 Curiosidades de la Uni</button>
          <button class="btn option" onclick="startQuiz('cg')">🌍 Cultura General</button>
          <button class="btn option" onclick="startQuiz('img')">🖼️ Conoce tu Campus (Imágenes)</button>
          <button class="btn option" onclick="startQuiz('lol')">😂 El Quiz más serio (pero no tanto)</button>
        </div>
      </section>

      <!-- QUIZ SCREEN (reusable) -->
      <section id="QUIZ" class="screen">
        <div class="topbar">
          <div class="muted" id="quizTitle">Quiz</div>
          <div class="muted" id="qIndex">1/10</div>
        </div>
        <div class="progress" aria-label="Progreso"><i id="qProgress"></i></div>
        <div id="qImage" class="imgbox" style="display:none; margin-top:14px;">[Imagen de referencia]</div>
        <div class="question" id="qText">Pregunta aquí…</div>
        <div class="options" id="qOptions"></div>
        <div class="row" style="margin-top:14px">
          <button class="btn" onclick="go('HOME_Menu')">Menú</button>
        </div>
      </section>

      <!-- RESULT (generic) -->
      <section id="RESULT" class="screen center">
        <h2 id="resultTitle">¡Listo! 🎉</h2>
        <p id="resultDesc" class="muted">Has terminado este quiz.</p>
        <div class="row">
          <button class="btn" onclick="restartQuiz()">Repetir</button>
          <button class="btn primary" onclick="go('HOME_Menu')">Menú principal</button>
        </div>
      </section>

      <!-- THANKS (for LOL) -->
      <section id="THANKS" class="screen center">
        <h2>🎉 ¡Sobreviviste al quiz más serio de la uni!</h2>
        <p class="muted">Gracias por jugar 😜</p>
        <div class="row">
          <button class="btn" onclick="restartQuiz()">Volver a jugar</button>
          <button class="btn primary" onclick="go('HOME_Menu')">Menú principal</button>
        </div>
      </section>

    </div>
  </div>

  <script>
    // --- Data --------------------------------------------------------------
    const quizzes = {
      uni: {
        name: '🏫 Curiosidades de la Uni',
        resultTitle: '¡Terminaste el quiz de la Uni! 👏',
        resultDesc: 'Ahora conoces más tu universidad: historia, espacios y servicios.',
        questions: [
          { q: '¿En qué año se fundó la universidad?', a: ['1975','1982','1990'] },
          { q: '¿Cuál es el edificio más antiguo del campus?', a: ['Rectoría','Biblioteca Central','Facultad de Derecho'] },
          { q: '¿Qué color representa a la universidad?', a: ['Azul y oro','Rojo y blanco','Verde y negro'] },
          { q: '¿Cuántas bibliotecas tiene la universidad?', a: ['1','2','3 o más'] },
          { q: '¿Cuál es el evento estudiantil más grande del año?', a: ['Semana cultural','Feria de servicio social','Festival deportivo'] },
          { q: '¿Qué servicio gratuito casi nadie aprovecha?', a: ['Asesorías académicas','Atención psicológica','Clubes estudiantiles'] },
          { q: '¿Qué egresado/visitante famoso nos ha dado prestigio?', a: ['Investigador premiado','Artista reconocido','Deportista destacado'] },
          { q: '¿Cuál cafetería/comedor tiene mayor capacidad?', a: ['Café Norte','Cafetería Central','Comedor Universitario'] },
          { q: '¿Dónde está el mural más famoso del campus?', a: ['Rectoría','Biblioteca','Auditorio'] },
          { q: '¿Qué programa apoya a estudiantes foráneos?', a: ['Residencias','Tutoría de pares','Becas de transporte'] },
        ]
      },
      cg: {
        name: '🌍 Cultura General',
        resultTitle: '¡Bien jugado! 🌟',
        resultDesc: 'Formación integral: más allá de tu carrera académica.',
        questions: [
          { q: '¿Cuál es el país con más universidades?', a: ['EE. UU.','India','China'] },
          { q: '¿Qué científico mexicano ganó el Nobel de Química (1995)?', a: ['Mario Molina','Luis Miramontes','José Sarukhán'] },
          { q: '¿Qué idioma es el más hablado como lengua materna?', a: ['Chino mandarín','Hindi','Español'] },
          { q: '¿Qué ciudad es cuna de las universidades modernas?', a: ['Bolonia','Oxford','París'] },
          { q: '¿Qué elemento tiene símbolo "Fe"?', a: ['Hierro','Flúor','Fermio'] },
          { q: '¿Cuál es la capital cultural de México?', a: ['Guadalajara','Ciudad de México','Oaxaca'] },
          { q: '¿Qué invento revolucionó la impresión en el s. XV?', a: ['Imprenta de Gutenberg','Linotipo','Offset'] },
          { q: '¿Qué filósofo enseñaba en la Academia de Atenas?', a: ['Platón','Aristóteles','Sócrates'] },
          { q: '¿Quién otorga los premios Nobel?', a: ['Academia Sueca','ONU','Royal Society'] },
          { q: '¿Cuál es el océano más grande?', a: ['Pacífico','Atlántico','Índico'] },
        ]
      },
      img: {
        name: '🖼️ Conoce tu Campus (Imágenes)',
        resultTitle: '¡Conoces tu campus! 🏫✨',
        resultDesc: 'Identificaste espacios, símbolos y patrimonio de la uni.',
        questions: [
          { q: '¿Cómo se llama este edificio?', img: '📚 Biblioteca Central (mock)', a: ['Biblioteca Central','Rectoría','Auditorio Principal'] },
          { q: '¿Cómo se llama esta escultura/mural?', img: '🎨 Mural icónico (mock)', a: ['Mural A','Mural B','Mural C'] },
          { q: '¿A qué facultad pertenece este laboratorio?', img: '🧪 Laboratorio (mock)', a: ['Ingeniería','Química','Biología'] },
          { q: '¿Qué eventos se realizan aquí?', img: '🎭 Auditorio (mock)', a: ['Obras y conferencias','Torneos','Feria de empleo'] },
          { q: '¿Qué representa este símbolo?', img: '🛡️ Escudo/Mascota (mock)', a: ['Identidad','Historia','Deporte'] },
          { q: '¿Qué actividades masivas se hacen aquí?', img: '🟩 Explanada (mock)', a: ['Festivales','Clases abiertas','Graduaciones'] },
          { q: '¿Cómo se llama este espacio verde?', img: '🌳 Áreas verdes (mock)', a: ['Bosquecito','Jardín Central','Parque Norte'] },
          { q: '¿Qué servicio encuentras aquí?', img: '🏢 Edificio administrativo (mock)', a: ['Becas','Titulación','Servicios escolares'] },
          { q: '¿Qué recuerda este monumento?', img: '🗿 Conmemorativo (mock)', a: ['Fundación','Aniversario','Personaje'] },
          { q: '¿Nombre oficial de la entrada principal?', img: '🚪 Entrada (mock)', a: ['Acceso Norte','Acceso Central','Acceso Histórico'] },
        ]
      },
      lol: {
        name: '😂 El Quiz más serio (pero no tanto)',
        thankYou: true,
        questions: [
          { q: '¿Quién es más fuerte?', a: ['Hulk','Tu profe de cálculo','Gokú'] },
          { q: 'Si llegas tarde, ¿qué dices?', a: ['Había tráfico','Me dormí','Me abdujeron los aliens'] },
          { q: '¿Mejor lugar para estudiar?', a: ['Biblioteca','Cafetería','Mi cama 😴'] },
          { q: '¿Qué es más difícil que cálculo?', a: ['Llegar 7am','Entender indirectas','Comer sin fila'] },
          { q: 'Superpoder en la uni:', a: ['Copiar invisible','Dormir y aprender','Rebobinar semestre'] },
          { q: '¿Quién aprueba más fácil?', a: ['Einstein','El de la guía','El de los apuntes'] },
          { q: 'Si tu carrera fuera serie…', a: ['Game of Thrones','Sherlock','The Office'] },
          { q: 'Siempre llevas en mochila:', a: ['Cuadernos','Laptop','Galletas y audífonos'] },
          { q: 'Trabajo en equipo =', a: ['Líder','Invisible','Aporto memes'] },
          { q: 'Estrategia de supervivencia:', a: ['Calendario','Café','Rezar'] },
        ]
      }
    };

    // --- State -------------------------------------------------------------
    let current = { key: null, i: 0 };

    // --- Helpers -----------------------------------------------------------
    function go(id){
      document.querySelectorAll('.screen').forEach(s=>s.classList.remove('active'));
      document.getElementById(id).classList.add('active');
    }

    function startQuiz(key){
      current = { key, i: 0 };
      renderQuestion();
      go('QUIZ');
    }

    function restartQuiz(){
      if(!current.key) return go('HOME_Menu');
      startQuiz(current.key);
    }

    function renderQuestion(){
      const quiz = quizzes[current.key];
      const list = quiz.questions;
      const i = current.i;
      if(i >= list.length){
        if(quiz.thankYou){
          go('THANKS');
        } else {
          document.getElementById('resultTitle').textContent = quiz.resultTitle || '¡Listo!';
          document.getElementById('resultDesc').textContent = quiz.resultDesc || 'Has terminado este quiz.';
          go('RESULT');
        }
        return;
      }
      // Set title & progress
      document.getElementById('quizTitle').textContent = quiz.name;
      document.getElementById('qIndex').textContent = `${i+1}/${list.length}`;
      document.getElementById('qProgress').style.width = `${((i)/list.length)*100}%`;

      const item = list[i];
      const qText = document.getElementById('qText');
      qText.textContent = item.q;

      const qImg = document.getElementById('qImage');
      if(item.img){ qImg.style.display='block'; qImg.textContent = item.img; }
      else { qImg.style.display='none'; }

      const box = document.getElementById('qOptions');
      box.innerHTML = '';
      item.a.forEach((label)=>{
        const b = document.createElement('button');
        b.className = 'option';
        b.type = 'button';
        b.textContent = label;
        b.onclick = () => { current.i++; renderQuestion(); };
        box.appendChild(b);
      });
    }
  </script>
</body>
</html>
