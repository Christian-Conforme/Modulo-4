from fastapi import APIRouter, Depends
from sqlalchemy.ext.asyncio import AsyncSession
from app.db.base import SessionLocal
from app.schemas.rol import RolCreate, RolOut
from app.services.rol import get_roles, create_rol
from app.api.routes.auth import get_current_user

router = APIRouter()

async def get_db():
    async with SessionLocal() as session:
        yield session

@router.get("/", response_model=list[RolOut])
async def listar_roles(db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await get_roles(db)

@router.post("/", response_model=RolOut)
async def crear_rol(data: RolCreate, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await create_rol(db, data)