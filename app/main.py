import logging
logging.getLogger("sqlalchemy.engine").setLevel(logging.WARNING)
logging.basicConfig()
from fastapi import FastAPI
from app.api.api import api_router
from app.db.base import init_db
import uvicorn

app = FastAPI(title="Administración Interna - Alquiler Autos")

@app.on_event("startup")
async def startup():
    await init_db()
    print("✅ Conectado a la base de datos")

app.include_router(api_router)

if __name__ == "__main__":
    uvicorn.run("app.main:app", host="0.0.0.0", port=8000, reload=True)